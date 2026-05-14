<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class NewsController extends Controller
{
    protected function uploadRootPath(): string
    {
        // =====================================================
        // PATCH:
        // ใช้ DOCUMENT_ROOT เพื่อให้ path ตรงกับ public จริงบน host
        // เช่น httpdocs/public หรือ public_html
        // =====================================================
        return rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR);
    }

    protected function saveNewsImage($file): string
    {
        $relativeDir = 'upload/news';
        $relativePathDir = $this->uploadRootPath() . DIRECTORY_SEPARATOR . $relativeDir;

        // =====================================================
        // PATCH:
        // สร้างโฟลเดอร์ถ้ายังไม่มี
        // =====================================================
        if (!File::exists($relativePathDir)) {
            File::makeDirectory($relativePathDir, 0755, true);
        }

        $filename = Str::uuid()->toString() . '.jpg';
        $relativePath = $relativeDir . '/' . $filename;
        $fullPath = $this->uploadRootPath() . DIRECTORY_SEPARATOR . $relativePath;

        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath());

        // =====================================================
        // PATCH:
        // หมุนภาพอัตโนมัติจากมือถือ
        // =====================================================
        $image = $image->orient();

        // =====================================================
        // PATCH:
        // ลดขนาดภาพข่าว
        // ข่าวหน้าแรกไม่ควรใช้ภาพใหญ่เกินไป
        // =====================================================
        $image->scaleDown(width: 1000);

        // =====================================================
        // PATCH:
        // บันทึกเป็น Progressive JPEG
        // โหลดไวขึ้นบนเว็บจริง
        // =====================================================
        $encoded = $image->toJpeg(
            quality: 70,
            progressive: true
        );

        $encoded->save($fullPath);

        return $relativePath;
    }

    public function index()
    {
        $news = News::latest()->paginate(9);

        return view('landing.news.index', compact('news'));
    }

    public function create()
    {
        return view('landing.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',

            // =====================================================
            // PATCH:
            // รองรับรูปจากมือถือไม่เกิน 10MB
            // แล้วบีบอัดเองก่อนบันทึก
            // =====================================================
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'title.required' => 'กรุณากรอกหัวข้อข่าว',
            'description.required' => 'กรุณากรอกรายละเอียดข่าว',
            'image.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'image.mimes' => 'รูปภาพต้องเป็นไฟล์ jpg, jpeg, png หรือ webp',
            'image.max' => 'รูปภาพต้องมีขนาดไม่เกิน 10MB',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $this->saveNewsImage($request->file('image'));
        }

        News::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $path,
        ]);

        return redirect()
            ->route('news.index')
            ->with('success', 'เพิ่มข่าวเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $news = News::findOrFail($id);

        return view('landing.news.show', compact('news'));
    }
}