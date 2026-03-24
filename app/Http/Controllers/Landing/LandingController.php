<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\News;



class LandingController extends Controller
{
   public function index()
    {
      // ดึงข่าวล่าสุด 6 รายการ
        $news = News::latest()->take(6)->get();
        return view('landing.index', compact('news'));



    }

    }


