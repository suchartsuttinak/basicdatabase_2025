<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issue;

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
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'subject'  => 'required|string',
        ]);

        Issue::create([
            'fullname' => $request->fullname,
            'phone'    => $request->phone,
            'subject'  => $request->subject,
        ]);

        return redirect()->route('issues.index')->with('success', 'บันทึกการแจ้งปัญหาเรียบร้อยแล้ว');
    }
}