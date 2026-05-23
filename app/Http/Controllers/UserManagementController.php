<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Project;
use App\Models\House;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        $stats = [
            'total' => User::count(),
            'active' => User::where('status', '1')->count(),
            'admin' => User::where('role', User::ROLE_ADMIN)->count(),
            'executive' => User::where('role', User::ROLE_EXECUTIVE)->count(),
            'social_worker' => User::where('role', User::ROLE_SOCIAL_WORKER)->count(),
            'teacher_caregiver' => User::where('role', User::ROLE_TEACHER_CAREGIVER)->count(),
        ];

        return view('backend.users.index', compact('users', 'stats'));
    }

     public function create()
    {
        $roles = User::roleOptions();

        $projects = Project::orderBy('project_name')->get();

        $houses = House::orderBy('house_name')->get();

        return view('backend.users.create', compact(
            'roles',
            'projects',
            'houses'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'role' => ['required', Rule::in(array_keys(User::roleOptions()))],
            'status' => ['required', Rule::in(['0', '1'])],
            'project_id' => ['nullable', 'exists:projects,id'],
            'house_ids' => ['nullable', 'array'],
            'house_ids.*' => ['integer', 'exists:houses,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.unique' => 'อีเมลนี้ถูกใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.confirmed' => 'ยืนยันรหัสผ่านไม่ตรงกัน',
            'role.required' => 'กรุณาเลือกสิทธิ์ผู้ใช้งาน',
            'status.required' => 'กรุณาเลือกสถานะ',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . preg_replace('/\s+/', '_', $request->file('photo')->getClientOriginalName());
            $request->file('photo')->move(public_path('upload/user_images'), $photoName);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $photoName,
            'role' => $request->role,
            'status' => $request->status,
            'project_id' => $request->project_id,
        ]);

        $user->houses()->sync($request->input('house_ids', []));

        return redirect()->route('users.index')->with('success', 'เพิ่มผู้ใช้งานเรียบร้อยแล้ว');
    }



        public function edit($id)
        {
            $user = User::with('houses')->findOrFail($id);

            $roles = User::roleOptions();
            $projects = Project::orderBy('project_name')->get();
            $houses = House::orderBy('house_name')->get();

            return view('backend.users.edit', compact(
                'user',
                'roles',
                'projects',
                'houses'
            ));
        }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'role' => ['required', Rule::in(array_keys(User::roleOptions()))],
            'status' => ['required', Rule::in(['0', '1'])],
            'project_id' => ['nullable', 'exists:projects,id'],
            'house_ids' => ['nullable', 'array'],
            'house_ids.*' => ['integer', 'exists:houses,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.unique' => 'อีเมลนี้ถูกใช้งานแล้ว',
            'password.confirmed' => 'ยืนยันรหัสผ่านไม่ตรงกัน',
            'role.required' => 'กรุณาเลือกสิทธิ์ผู้ใช้งาน',
            'status.required' => 'กรุณาเลือกสถานะ',
        ]);

        $photoName = $user->photo;

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . preg_replace('/\s+/', '_', $request->file('photo')->getClientOriginalName());
            $request->file('photo')->move(public_path('upload/user_images'), $photoName);
        }

       $data = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'photo' => $photoName,
        'role' => $request->role,
        'status' => $request->status,
        'project_id' => $request->project_id,
    ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        $user->houses()->sync($request->input('house_ids', []));

        return redirect()->route('users.index')->with('success', 'อัปเดตข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'ไม่สามารถลบบัญชีของตนเองได้');
        }

        if ($user->role === User::ROLE_ADMIN && User::where('role', User::ROLE_ADMIN)->count() <= 1) {
            return redirect()->back()->with('error', 'ไม่สามารถลบผู้ดูแลระบบคนสุดท้ายได้');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'ลบผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'ไม่สามารถเปลี่ยนสถานะบัญชีของตนเองได้');
        }

        $user->status = (string) $user->status === '1' ? '0' : '1';
        $user->save();

        return redirect()->back()->with('success', 'อัปเดตสถานะผู้ใช้งานเรียบร้อยแล้ว');
    }
}