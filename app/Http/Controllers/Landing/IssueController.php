<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    // แสดงรายการแจ้งปัญหา
    public function index()
    {
        $issues = Issue::latest()->paginate(10);

        return view('landing.issues.index', compact('issues'));
    }

    // บันทึกการแจ้งปัญหา
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'subject'  => 'required|string',
        ], [
            'fullname.required' => 'กรุณากรอกชื่อ-สกุลผู้แจ้ง',
            'fullname.string'   => 'ชื่อ-สกุลต้องเป็นข้อความ',
            'fullname.max'      => 'ชื่อ-สกุลต้องไม่เกิน 255 ตัวอักษร',

            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'phone.string'   => 'เบอร์โทรศัพท์ต้องเป็นข้อความ',
            'phone.max'      => 'เบอร์โทรศัพท์ต้องไม่เกิน 20 ตัวอักษร',

            'subject.required' => 'กรุณากรอกเรื่องที่แจ้ง',
            'subject.string'   => 'เรื่องที่แจ้งต้องเป็นข้อความ',
        ]);

        Issue::create([
            'fullname' => $validated['fullname'],
            'phone'    => $validated['phone'],
            'subject'  => $validated['subject'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'แจ้งเรื่องช่วยเหลือสำเร็จแล้ว');
    }
}