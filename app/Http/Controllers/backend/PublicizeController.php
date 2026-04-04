<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Publicize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PublicizeController extends Controller
{
    public function index(Request $request)
    {
        $categories = ['all' => 'ทั้งหมด'] + Publicize::CATEGORIES;

        $activeCategory = $request->get('category', 'all');
        $yearBe = $request->get('year_be');

        if (!array_key_exists($activeCategory, $categories)) {
            $activeCategory = 'all';
        }

        $query = Publicize::query();

        if ($activeCategory !== 'all') {
            $query->where('category', $activeCategory);
        }

        if (!empty($yearBe) && is_numeric($yearBe)) {
            $yearAd = (int) $yearBe - 543;
            $query->whereYear('recorded_at', $yearAd);
        }

        $publicizes = $query
            ->orderByDesc('recorded_at')
            ->orderByDesc('id')
            ->get();

        $yearOptions = Publicize::selectRaw('YEAR(recorded_at) as year_ad')
            ->distinct()
            ->orderByDesc('year_ad')
            ->pluck('year_ad')
            ->mapWithKeys(function ($yearAd) {
                return [$yearAd + 543 => $yearAd + 543];
            });

        $categoryCounts = [];
        foreach (Publicize::CATEGORIES as $key => $label) {
            $countQuery = Publicize::query()->where('category', $key);

            if (!empty($yearBe) && is_numeric($yearBe)) {
                $countQuery->whereYear('recorded_at', ((int) $yearBe - 543));
            }

            $categoryCounts[$key] = $countQuery->count();
        }

        $allCountQuery = Publicize::query();
        if (!empty($yearBe) && is_numeric($yearBe)) {
            $allCountQuery->whereYear('recorded_at', ((int) $yearBe - 543));
        }
        $categoryCounts['all'] = $allCountQuery->count();

        return view('backend.publicizes.index', compact(
            'categories',
            'activeCategory',
            'publicizes',
            'yearOptions',
            'yearBe',
            'categoryCounts'
        ));
    }

    public function create()
    {
        $categories = Publicize::CATEGORIES;
        return view('backend.publicizes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $categories = array_keys(Publicize::CATEGORIES);

        $validated = $request->validate([
            'recorded_at' => ['required', 'date'],
            'category'    => ['required', Rule::in($categories)],
            'title'       => ['required', 'string', 'max:255'],
            'file'        => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'recorded_at.required' => 'กรุณาเลือกวันที่บันทึก',
            'category.required'    => 'กรุณาเลือกประเภท',
            'title.required'       => 'กรุณากรอกชื่อเรื่อง',
            'file.required'        => 'กรุณาอัปโหลดไฟล์ PDF',
            'file.mimes'           => 'รองรับเฉพาะไฟล์ PDF เท่านั้น',
            'file.max'             => 'ขนาดไฟล์ต้องไม่เกิน 10 MB',
        ]);

        $folder = 'publicizes/' . $validated['category'];
        $file = $request->file('file');

        $filename = now()->format('YmdHis') . '_' . uniqid() . '.pdf';
        $path = $file->storeAs($folder, $filename, 'public');

        Publicize::create([
            'recorded_at' => $validated['recorded_at'],
            'category'    => $validated['category'],
            'title'       => $validated['title'],
            'file_path'   => $path,
            'file_name'   => $file->getClientOriginalName(),
        ]);

        return redirect()
            ->route('publicizes.index', ['category' => $validated['category']])
            ->with('success', 'บันทึกข้อมูลประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    public function edit(Publicize $publicize)
    {
        $categories = Publicize::CATEGORIES;
        return view('backend.publicizes.edit', compact('publicize', 'categories'));
    }

    public function update(Request $request, Publicize $publicize)
    {
        $categories = array_keys(Publicize::CATEGORIES);

        $validated = $request->validate([
            'recorded_at' => ['required', 'date'],
            'category'    => ['required', Rule::in($categories)],
            'title'       => ['required', 'string', 'max:255'],
            'file'        => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'recorded_at.required' => 'กรุณาเลือกวันที่บันทึก',
            'category.required'    => 'กรุณาเลือกประเภท',
            'title.required'       => 'กรุณากรอกชื่อเรื่อง',
            'file.mimes'           => 'รองรับเฉพาะไฟล์ PDF เท่านั้น',
            'file.max'             => 'ขนาดไฟล์ต้องไม่เกิน 10 MB',
        ]);

        $data = [
            'recorded_at' => $validated['recorded_at'],
            'category'    => $validated['category'],
            'title'       => $validated['title'],
        ];

        if ($request->hasFile('file')) {
            if ($publicize->file_path && Storage::disk('public')->exists($publicize->file_path)) {
                Storage::disk('public')->delete($publicize->file_path);
            }

            $folder = 'publicizes/' . $validated['category'];
            $file = $request->file('file');
            $filename = now()->format('YmdHis') . '_' . uniqid() . '.pdf';
            $path = $file->storeAs($folder, $filename, 'public');

            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $publicize->update($data);

        return redirect()
            ->route('publicizes.index', ['category' => $validated['category']])
            ->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy(Publicize $publicize)
    {
        $category = $publicize->category;

        if ($publicize->file_path && Storage::disk('public')->exists($publicize->file_path)) {
            Storage::disk('public')->delete($publicize->file_path);
        }

        $publicize->delete();

        return redirect()
            ->route('publicizes.index', ['category' => $category])
            ->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}