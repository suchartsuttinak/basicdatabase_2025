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
    // =========================
    // PATCH: กันเดา URL เข้า client
    // =========================
    $client = Client::forUser(auth()->user())->findOrFail($client_id);

    $escapes = Escape::with(['retire','follows'])
                     ->where('client_id', $client_id)
                     ->get();
    $retires = Retire::all();

    return view('frontend.client.escape.escape_index', compact('client','escapes','retires'));
}

    // หน้า AddEscape (ฟอร์มเพิ่มใหม่)
    public function AddEscape($client_id)
    {
        // =========================
        // PATCH: กันเดา URL เข้า client
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($client_id);

        $retires = Retire::all();
        $mode = 'create';

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

        // =========================
        // PATCH: กันยิง request เปลี่ยน client_id
        // =========================
        Client::forUser(auth()->user())->findOrFail($data['client_id']);

        $escape = Escape::create($data);

        return redirect()
            ->route('escape.edit', $escape->id)
            ->with(['message' => 'บันทึกข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);
    }

    // หน้า EditEscape (ฟอร์มแก้ไข)
    public function EditEscape($id)
    {
        $escape = Escape::with(['client','retire','follows'])->findOrFail($id);

        // =========================
        // PATCH: กันเข้าดู record คนอื่น
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($escape->client_id);

        $retires = Retire::all();

        return view('frontend.client.escape.escape_edit', compact('escape','retires','client'));
    }

    // อัปเดต Escape ที่มีอยู่แล้ว
    public function UpdateEscape(Request $request, $id)
    {
      $escape = Escape::findOrFail($id);

        // =========================
        // PATCH: กัน update record คนอื่น
        // =========================
        Client::forUser(auth()->user())->findOrFail($escape->client_id);

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

        // =========================
        // PATCH: กันเปลี่ยน client_id
        // =========================
        Client::forUser(auth()->user())->findOrFail($data['client_id']);

        $escape->update($data);

        return redirect()
            ->route('escape.edit', $escape->id)
            ->with(['message' => 'แก้ไขข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);
    }

    public function DeleteEscape($id)
{
        $escape = Escape::findOrFail($id);

        // =========================
        // PATCH: กันลบ record คนอื่น
        // =========================
        Client::forUser(auth()->user())->findOrFail($escape->client_id);

        $client_id = $escape->client_id;
        $escape->delete();

        return redirect()
            ->route('escape.index', $client_id)
            ->with(['message' => 'ลบข้อมูลการออกเรียบร้อย', 'alert-type' => 'success']);
}

    public function CopyEscape($id)
    {
        $escape = Escape::with(['client','retire'])->findOrFail($id);

        // =========================
        // PATCH: กัน copy ข้อมูลของ client คนอื่น
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($escape->client_id);

        $retires = Retire::all();
        $mode = 'copy';

        return view('frontend.client.escape.escape_create', compact('client','retires','escape','mode'));
    }

    public function ReportEscape($id)
{
    $escape = Escape::with([
        'client',
        'retire',
        'follows' => function ($query) {
            $query->orderBy('count', 'asc')->orderBy('trace_date', 'asc');
        }
    ])->findOrFail($id);

    // =========================
    // PATCH: กันเข้าดู report ของ client คนอื่น
    // =========================
    $client = Client::forUser(auth()->user())->findOrFail($escape->client_id);

    return view('frontend.client.escape.escape_report', compact('escape', 'client'));
}
}