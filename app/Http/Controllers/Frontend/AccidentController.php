<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Accident;

class AccidentController extends Controller
{
    // 🟢 แสดงฟอร์มเพิ่มข้อมูล
    public function AccidentAdd($client_id)
    {
        $client = Client::findOrFail($client_id);
        $accidents = Accident::where('client_id', $client->id)
        ->orderBy('incident_date', 'desc') // เรียงวันที่ล่าสุดก่อน
        ->get();
         $accident = null; // สำหรับเพิ่มใหม่

        return view('frontend.client.accident.accident_create', compact('client', 'client_id', 'accidents', 'accident'));
    }

    // 🟢 บันทึกข้อมูลใหม่
    // 🟢 บันทึกข้อมูลใหม่
public function AccidentStore(Request $request)
{
    // ตรวจสอบข้อมูลที่ส่งเข้ามา พร้อมข้อความผิดพลาดภาษาไทย
    $validated = $request->validate([
        'client_id'     => 'required|exists:clients,id',
        'incident_date' => 'required|date',
        'location'      => 'required|string|max:255',
        'eyewitness'    => 'nullable|string|max:255',
        'detail'        => 'required|string',
        'cause'         => 'required|string|max:255',
        'treat_no'      => 'required|string|max:255',
        'hospital'      => 'nullable|string|max:255',
        'diagnosis'     => 'nullable|string|max:255',
        'appointment'   => 'nullable|string|max:255',
        'protection'    => 'nullable|string|max:255',
        'treatment'     => 'nullable|string|max:255',
        'caretaker'     => 'nullable|string|max:255',
        'record_date'   => 'required|date',
    ],[
        'client_id.required'     => 'กรุณาเลือกชื่อลูกค้า',
        'client_id.exists'       => 'ลูกค้าที่เลือกไม่ถูกต้อง',
        'incident_date.required' => 'กรุณาระบุวันที่เกิดเหตุ',
        'incident_date.date'     => 'วันที่เกิดเหตุต้องเป็นรูปแบบวันที่',
        'location.required'      => 'กรุณาระบุสถานที่เกิดเหตุ',
        'location.string'        => 'สถานที่เกิดเหตุต้องเป็นข้อความ',
        'location.max'           => 'สถานที่เกิดเหตุต้องไม่เกิน 255 ตัวอักษร',
        'detail.required'        => 'กรุณาระบุรายละเอียด',
        'cause.required'         => 'กรุณาระบุสาเหตุ',
        'cause.max'              => 'สาเหตุต้องไม่เกิน 255 ตัวอักษร',
        'treat_no.required' => 'กรุณาเลือกการรักษาพยาบาล',
        'treat_no.string'   => 'การรักษาพยาบาลต้องเป็นข้อความ',
        'treat_no.max'      => 'การรักษาพยาบาลต้องไม่เกิน 255 ตัวอักษร',
        'record_date.required'   => 'กรุณาระบุวันที่บันทึก',
        'record_date.date'       => 'วันที่บันทึกต้องเป็นรูปแบบวันที่',
    ]);


    // ถ้าเลือก "ไม่พบแพทย์" → ล้างค่าฟิลด์ที่เกี่ยวข้อง
    if (!empty($validated['treat_no']) && $validated['treat_no'] === 'ไม่พบแพทย์') {
        $validated['hospital']    = null;
        $validated['diagnosis']   = null;
        $validated['appointment'] = null;
    }

    // บันทึกข้อมูลใหม่
    Accident::create($validated);

    // ส่งกลับพร้อมข้อความแจ้งเตือนภาษาไทย
    return redirect()
        ->route('accident.add', $request->client_id)
        ->with([
            'message'    => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ]);
}

// 🟢 แก้ไขข้อมูล (ใช้ฟอร์มเดิม)
public function AccidentEdit($id)
{
    $accident   = Accident::findOrFail($id);
    $client     = $accident->client;
    $accidents  = Accident::where('client_id', $client->id)->latest()->get();

    return view('frontend.client.accident.accident_create', compact('client', 'accidents', 'accident'))
        ->with('client_id', $client->id);
}

// 🟢 อัปเดตข้อมูล
public function AccidentUpdate(Request $request, $id)
{
    // ตรวจสอบข้อมูลที่ส่งเข้ามา พร้อมข้อความผิดพลาดภาษาไทย
    $validated = $request->validate([
        'client_id'     => 'required|exists:clients,id',
        'incident_date' => 'required|date',
        'location'      => 'required|string|max:255',
        'eyewitness'    => 'nullable|string|max:255',
        'detail'        => 'required|string',
        'cause'         => 'required|string|max:255',
        'treat_no'      => 'required|string|max:255',
        'hospital'      => 'nullable|string|max:255',
        'diagnosis'     => 'nullable|string|max:255',
        'appointment'   => 'nullable|string|max:255',
        'protection'    => 'nullable|string|max:255',
        'treatment'     => 'nullable|string|max:255',
        'caretaker'     => 'nullable|string|max:255',
        'record_date'   => 'required|date',
    ],[
        'client_id.required'     => 'กรุณาเลือกชื่อลูกค้า',
        'client_id.exists'       => 'ลูกค้าที่เลือกไม่ถูกต้อง',
        'incident_date.required' => 'กรุณาระบุวันที่เกิดเหตุ',
        'incident_date.date'     => 'วันที่เกิดเหตุต้องเป็นรูปแบบวันที่',
        'location.required'      => 'กรุณาระบุสถานที่เกิดเหตุ',
        'location.string'        => 'สถานที่เกิดเหตุต้องเป็นข้อความ',
        'location.max'           => 'สถานที่เกิดเหตุต้องไม่เกิน 255 ตัวอักษร',
        'detail.required'        => 'กรุณาระบุรายละเอียด',
        'cause.required'         => 'กรุณาระบุสาเหตุ',
        'cause.max'              => 'สาเหตุต้องไม่เกิน 255 ตัวอักษร',
        'treat_no.required' => 'กรุณาเลือกการรักษาพยาบาล',
        'treat_no.string'   => 'การรักษาพยาบาลต้องเป็นข้อความ',
        'treat_no.max'      => 'การรักษาพยาบาลต้องไม่เกิน 255 ตัวอักษร',
        'record_date.required'   => 'กรุณาระบุวันที่บันทึก',
        'record_date.date'       => 'วันที่บันทึกต้องเป็นรูปแบบวันที่',
    ]);

    // ค้นหา Accident ตาม id
    $accident = Accident::findOrFail($id);

    // ถ้าเลือก "ไม่พบแพทย์" → ล้างค่าฟิลด์ที่เกี่ยวข้อง
    if (!empty($validated['treat_no']) && $validated['treat_no'] === 'ไม่พบแพทย์') {
        $validated['hospital']    = null;
        $validated['diagnosis']   = null;
        $validated['appointment'] = null;
    }

    // อัปเดตข้อมูล
    $accident->update($validated);

    // ส่งกลับพร้อมข้อความแจ้งเตือนภาษาไทย
    return redirect()
        ->route('accident.add', $accident->client_id)
        ->with([
            'message'    => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ]);
}

    // 🟢 ลบข้อมูล
    public function AccidentDelete($id)
    {
        $accident = Accident::findOrFail($id);
        $clientId = $accident->client_id;
        $accident->delete();

        return redirect()
            ->route('accident.add', $clientId)
            ->with(['message' => 'ลบข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }
}