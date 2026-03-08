<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Addictive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;

class AddictiveController extends Controller
{
    // โหลดฟอร์ม + ข้อมูลเดิม
    public function AddAddictive($client_id)
    {
        $client = Client::findOrFail($client_id);

        $addictives = Addictive::where('client_id', $client->id)
            ->orderBy('date', 'desc')
            ->get();

        $addictive = null; // สำหรับเพิ่มใหม่

        return view('frontend.client.addictive.addictive_create', compact('client', 'client_id', 'addictives', 'addictive'));
    }

    // บันทึกข้อมูลใหม่
    public function StoreAddictive(Request $request)
    {
        $data = $request->validate([
            'date'       => 'required|date',
            'exam'       => 'required|in:0,1',
            'refer'      => 'nullable|in:1,2',
            'record'     => 'nullable|string',
            'recorder'   => 'required|string|max:255',
            'client_id'  => 'required|exists:clients,id',
        ], [
            'date.required'      => 'กรุณาระบุวันที่ตรวจ',
            'date.date'          => 'รูปแบบวันที่ไม่ถูกต้อง',
            'exam.required'      => 'กรุณาเลือกผลการตรวจ',
            'exam.in'            => 'ค่าที่เลือกไม่ถูกต้อง',
            'refer.in'           => 'ค่าการส่งต่อไม่ถูกต้อง',
            'record.string'      => 'บันทึกผลต้องเป็นข้อความ',
            'recorder.required'  => 'กรุณาระบุชื่อผู้ตรวจ',
            'recorder.string'    => 'ชื่อผู้ตรวจต้องเป็นข้อความ',
            'recorder.max'       => 'ชื่อผู้ตรวจต้องไม่เกิน 255 ตัวอักษร',
            'client_id.required' => 'ไม่พบรหัสผู้รับบริการ',
            'client_id.exists'   => 'รหัสผู้รับบริการไม่ถูกต้อง',
        ]);

        // นับจำนวนครั้งล่าสุด
        $latestCount = Addictive::where('client_id', $data['client_id'])->max('count') ?? 0;
        $nextCount = $latestCount + 1;

        // ตรวจสอบว่ามี count นี้อยู่แล้วหรือไม่
        $exists = Addictive::where('client_id', $data['client_id'])
                           ->where('count', $nextCount)
                           ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลซ้ำได้ (ครั้งที่ ' . $nextCount . ' มีอยู่แล้ว)', 'errors' => []]);
            }
            return redirect()->back()->with(['message' => 'ไม่สามารถบันทึกข้อมูลซ้ำได้ (ครั้งที่ ' . $nextCount . ' มีอยู่แล้ว)', 'alert-type' => 'error']);
        }

        $data['count'] = $nextCount;

        if ($data['exam'] == 0) {
            $data['refer'] = null;
        }

        $addictive = Addictive::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว', 'data' => $addictive]);
        }

        return redirect()->back()->with(['message' => 'บันทึกข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }

    // โหลดข้อมูลเดิมสำหรับแก้ไข (JSON)
    public function EditAddictiveJson($id)
    {
        $addictive = Addictive::findOrFail($id);

        return response()->json([
            'id'       => $addictive->id,
            'date'     => \Carbon\Carbon::parse($addictive->date)->format('Y-m-d'),
            'count'    => $addictive->count,
            'exam'     => $addictive->exam,
            'refer'    => $addictive->refer,
            'record'   => $addictive->record,
            'recorder' => $addictive->recorder,
        ]);
    }

    // อัปเดตข้อมูล
    public function UpdateAddictive(Request $request, $id)
    {
        $addictive = Addictive::findOrFail($id);

        $data = $request->validate([
            'date'     => 'required|date',
            'exam'     => 'required|in:0,1',
            'refer'    => 'nullable|in:1,2',
            'record'   => 'nullable|string',
            'recorder' => 'nullable|string|max:255',
        ]);

        if ($data['exam'] == 0) {
            $data['refer'] = null;
        }
        if (empty($data['recorder'])) {
            $data['recorder'] = 'ไม่ระบุ';
        }

        $addictive->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'อัปเดตข้อมูลเรียบร้อยแล้ว', 'data' => $addictive]);
        }

        return redirect()->route('addictive.create', $addictive->client_id)
                         ->with(['message' => 'อัปเดตข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }

    // ลบข้อมูล
    public function DeleteAddictive($id)
    {
        $addictive = Addictive::findOrFail($id);
        $clientId = $addictive->client_id;
        $addictive->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'ลบข้อมูลเรียบร้อยแล้ว']);
        }

        return redirect()->route('addictive.create', $clientId)
                         ->with(['message' => 'ลบข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }
}