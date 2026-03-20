<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Escape;
use App\Models\Retire;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $mode = 'create'; // ✅ บอกว่าเป็นการเพิ่มใหม่

        return view('frontend.client.escape.escape_create', compact('client','retires','mode'));
    }

    // บันทึก Escape ใหม่
    public function StoreEscape(Request $request)
    {
       $data = $request->validate([
        'client_id'   => 'required|exists:clients,id',
        'retire_date' => [
            'required',
            'date',
            Rule::unique('escapes')->where(function ($query) use ($request) {
                return $query->where('client_id', $request->client_id);
            }),
            ],
            'retire_id'   => 'required|exists:retires,id',
            'stories'     => 'nullable|string',
        ], [
            'client_id.required'   => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists'     => 'รหัสผู้รับบริการไม่ถูกต้อง',

            'retire_date.required' => 'กรุณาระบุวันที่เกษียณ',
            'retire_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
            'retire_date.unique'   => 'วันที่เกษียณนี้ถูกบันทึกแล้วสำหรับผู้รับบริการรายนี้',

            'retire_id.required'   => 'กรุณาเลือกประเภทการเกษียณ',
            'retire_id.exists'     => 'รหัสการเกษียณไม่ถูกต้อง',

            'stories.string'       => 'เรื่องราวต้องเป็นข้อความ',
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
            'retire_date' => [
                'required',
                'date',
                Rule::unique('escapes')->where(function ($query) use ($request) {
                    return $query->where('client_id', $request->client_id);
                })->ignore($id),
            ],
            'retire_id'   => 'required|exists:retires,id',
            'stories'     => 'nullable|string',
            'client_id'   => 'required|exists:clients,id',
        ], [
            'retire_date.required' => 'กรุณาระบุวันที่เกษียณ',
            'retire_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
            'retire_date.unique'   => 'วันที่เกษียณนี้ถูกบันทึกแล้วสำหรับผู้รับบริการรายนี้',

            'retire_id.required'   => 'กรุณาเลือกประเภทการเกษียณ',
            'retire_id.exists'     => 'รหัสการเกษียณไม่ถูกต้อง',

            'stories.string'       => 'เรื่องราวต้องเป็นข้อความ',

            'client_id.required'   => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists'     => 'รหัสผู้รับบริการไม่ถูกต้อง',
        ]);

        $escape->update($data);

        return redirect()
            ->route('escape.edit', $escape->id)
            ->with(['message' => 'แก้ไขข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);
    }

    public function DeleteEscape($id)
{
        $escape = Escape::findOrFail($id);
        $client_id = $escape->client_id; // ✅ เก็บ client_id ก่อนลบ
        $escape->delete();

        return redirect()
            ->route('escape.index', $client_id) // ✅ ส่ง client_id กลับไป
            ->with(['message' => 'ลบข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);


}

   

    public function CopyEscape($id)
    {
        $escape = Escape::with(['client','retire'])->findOrFail($id);
        $client = $escape->client;
        $retires = Retire::all();
        $mode = 'copy'; // ✅ ใช้ create แต่ prefill ข้อมูลเดิม

        return view('frontend.client.escape.escape_create', compact('client','retires','escape','mode'));
    }
    //  คือ ธงบอกสถานะ ให้ view รู้ว่า ตอนนี้ผู้ใช้กำลัง “คัดลอก” ข้อมูลเดิมมาแก้ไข
    // ฟอร์มต้อง prefill ค่าเดิม - ปุ่มและ action ต้องทำงานเหมือนโหมดแก้ไข (edit) → คือยิงไป UpdateEscape
}