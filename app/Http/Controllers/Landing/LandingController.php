<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\AboutData;
use App\Models\News;

class LandingController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลเกี่ยวกับเรา
        $history   = AboutData::where('type', 'history')->latest()->first();
        $objective = AboutData::where('type', 'objective')->latest()->first();
        $mission   = AboutData::where('type', 'mission')->latest()->first();

        // ดึงข่าวล่าสุด 6 รายการ
        $news = News::latest()->take(6)->get();

        // ส่งตัวแปรทั้งหมดไปที่หน้า Landing
        return view('landing.index', compact('history','objective','mission','news'));
    }
}
