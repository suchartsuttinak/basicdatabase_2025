<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\AboutData;

use Illuminate\Http\Request;

class AboutController extends Controller
{
     public function index()
    {
       $history   = AboutData::where('type', 'history')->latest()->first();
    $objective = AboutData::where('type', 'objective')->latest()->first();
    $mission   = AboutData::where('type', 'mission')->latest()->first();

    // ดึงข้อมูลทั้งหมดสำหรับตาราง
    $aboutData = AboutData::latest()->get();

    // โหลดหน้าฟอร์มกรอกข้อมูล (ไม่ใช่หน้า Landing)
    return view('landing.about.index', compact('history','objective','mission','aboutData'));

    }
    public function store(Request $request)
    {
        $request->validate([
        'type' => 'required|in:history,objective,mission',
        'content' => 'required|string',
    ]);

    AboutData::create([
        'type' => $request->type,
        'content' => $request->content,
    ]);

    // หลังบันทึกเสร็จ กลับไปหน้า Landing
    return redirect()->route('landing.about.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');


    }

    public function destroy($id)
{
    $data = AboutData::findOrFail($id);
    $data->delete();

    return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
}
}