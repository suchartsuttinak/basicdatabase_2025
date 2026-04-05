<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('houses')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $houses = House::orderBy('id')->get();
        return view('users.create', compact('houses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'role'                  => ['required', 'string', 'max:255'],
            'status'                => ['required', 'in:0,1'],
            'houses'                => ['nullable', 'array'],
            'houses.*'              => ['exists:houses,id'],
        ], [
            'name.required'         => 'กรุณากรอกชื่อผู้ใช้งาน',
            'email.required'        => 'กรุณากรอกอีเมล',
            'email.email'           => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique'          => 'อีเมลนี้ถูกใช้งานแล้ว',
            'password.required'     => 'กรุณากรอกรหัสผ่าน',
            'password.min'          => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
            'password.confirmed'    => 'ยืนยันรหัสผ่านไม่ตรงกัน',
            'role.required'         => 'กรุณาเลือกสิทธิ์ผู้ใช้งาน',
            'status.required'       => 'กรุณาเลือกสถานะ',
            'houses.*.exists'       => 'บ้านที่เลือกไม่ถูกต้อง',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'],
            'status'    => $validated['status'],
        ]);

        $user->houses()->sync($request->houses ?? []);

        return redirect()->route('users.index')->with('success', 'เพิ่มผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $user = User::with('houses')->findOrFail($id);
        $houses = House::orderBy('id')->get();

        return view('users.edit', compact('user', 'houses'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'              => ['nullable', 'string', 'min:6', 'confirmed'],
            'role'                  => ['required', 'string', 'max:255'],
            'status'                => ['required', 'in:0,1'],
            'houses'                => ['nullable', 'array'],
            'houses.*'              => ['exists:houses,id'],
        ], [
            'name.required'         => 'กรุณากรอกชื่อผู้ใช้งาน',
            'email.required'        => 'กรุณากรอกอีเมล',
            'email.email'           => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique'          => 'อีเมลนี้ถูกใช้งานแล้ว',
            'password.min'          => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
            'password.confirmed'    => 'ยืนยันรหัสผ่านไม่ตรงกัน',
            'role.required'         => 'กรุณาเลือกสิทธิ์ผู้ใช้งาน',
            'status.required'       => 'กรุณาเลือกสถานะ',
            'houses.*.exists'       => 'บ้านที่เลือกไม่ถูกต้อง',
        ]);

        $data = [
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'role'      => $validated['role'],
            'status'    => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);
        $user->houses()->sync($request->houses ?? []);

        return redirect()->route('users.index')->with('success', 'แก้ไขผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ((int) $user->id === (int) auth()->id()) {
            return redirect()->route('users.index')->with('error', 'ไม่สามารถปิดสถานะบัญชีของตนเองได้');
        }

        $user->status = (string) $user->status === '1' ? '0' : '1';
        $user->save();

        return redirect()->route('users.index')->with('success', 'เปลี่ยนสถานะผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ((int) $user->id === (int) auth()->id()) {
            return redirect()->route('users.index')->with('error', 'ไม่สามารถลบบัญชีของตนเองได้');
        }

        $user->houses()->detach();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'ลบผู้ใช้งานเรียบร้อยแล้ว');
    }
}