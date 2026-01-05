<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Retire;
use App\Models\Escape;

class EscapeController extends Controller
{
    // หน้า IndexEscape (แสดง Escape ทั้งหมด)
    public function IndexEscape($client_id)
{
    $client = Client::findOrFail($client_id);
    $escapes = Escape::with(['retire','follows'])
                     ->where('client_id', $client_id)
                     ->get();
    $retires = Retire::all();

    return view('frontend.client.escape.escape_index', compact('client','escapes','retires'));
}

    // หน้า AddEscape (ฟอร์มเพิ่มใหม่)
    public function AddEscape($client_id)
    {
        $client = Client::findOrFail($client_id);
        $retires = Retire::all();

        return view('frontend.client.escape.escape_create', compact('client','retires'));
    }

    // บันทึก Escape ใหม่
    public function StoreEscape(Request $request)
    {
        $data = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'retire_date' => 'required|date',
            'retire_id'   => 'required|exists:retires,id',
            'stories'     => 'nullable|string',
        ]);

        $escape = Escape::create($data);

        return redirect()
            ->route('escape.edit', $escape->id)
            ->with(['message' => 'บันทึกข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);
    }

    // หน้า EditEscape (ฟอร์มแก้ไข)
    public function EditEscape($id)
    {
        $escape = Escape::with(['client','retire','follows'])->findOrFail($id);
        $retires = Retire::all();
        $client = $escape->client; // เพิ่ม client เพื่อใช้ใน sidebar

        return view('frontend.client.escape.escape_edit', compact('escape','retires','client'));
    }

    // อัปเดต Escape ที่มีอยู่แล้ว
    public function UpdateEscape(Request $request, $id)
    {
        $escape = Escape::findOrFail($id);

        $data = $request->validate([
            'retire_date' => 'required|date',
            'retire_id'   => 'required|exists:retires,id',
            'stories'     => 'nullable|string',
        ]);

        $escape->update($data);

        return redirect()
            ->route('escape.edit', $escape->id)
            ->with(['message' => 'แก้ไขข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);
    }

    public function DeleteEscape($id)
{
    $escape = Escape::findOrFail($id);
    $escape->delete();

    return redirect()
        ->route('escape.index')
        ->with(['message' => 'ลบข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);
}

   
}