<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้

class SemesterController extends Controller
{
     // แสดงข้อมูลทั้งหมด
    public function SemesterShow()
    {
        $semester = Semester::latest()->get();
        return view('backend.semester.semester_show', compact('semester'));
    }

    // บันทึกข้อมูลใหม่
    public function SemesterStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'semester_name' => 'required|unique:semesters,semester_name'
        ], [
            'semester_name.required' => 'กรุณากรอกชื่อเทอม',
            'semester_name.unique'   => 'ชื่อเทอมนี้มีอยู่แล้วในระบบ'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Semester::create([
            'semester_name' => $request->semester_name
        ]);

        $notification = [
            'message'    => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    // ดึงข้อมูลเพื่อแก้ไข
    public function EditSemester($id)
    {
        $semester = Semester::find($id);
        return response()->json($semester);
    }

    // อัปเดตข้อมูล
    public function UpdateSemester(Request $request)
    {
        $sem_id = $request->sem_id;

        $validator = Validator::make($request->all(), [
            'semester_name' => 'required|unique:semesters,semester_name,' . $sem_id,
        ], [
            'semester_name.required' => 'กรุณากรอกชื่อเทอม',
            'semester_name.unique'   => 'ชื่อเทอมนี้มีอยู่แล้วในระบบ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        Semester::findOrFail($sem_id)->update([
            'semester_name' => $request->semester_name,
        ]);

        $notification = [
            'message'    => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    // ลบข้อมูล
    public function DeleteSemester($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();

        $notification = [
            'message'    => 'ลบข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}

