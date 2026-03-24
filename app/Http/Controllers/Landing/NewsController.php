<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // แสดงรายการข่าวทั้งหมด
    public function index()
    {
        // ใช้ paginate เพื่อแบ่งหน้า
        $news = News::latest()->paginate(9);
        return view('landing.news.index', compact('news'));
    }

    // ฟอร์มเพิ่มข่าว
    public function create()
    {
        return view('landing.news.create');
    }

    // บันทึกข่าวใหม่
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
        }

        News::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $path,
        ]);

        return redirect()->route('news.index')->with('success', 'เพิ่มข่าวเรียบร้อยแล้ว');
    }

    // แสดงรายละเอียดข่าว
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('landing.news.show', compact('news'));
    }
}