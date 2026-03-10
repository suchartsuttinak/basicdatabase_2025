<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Medical;
use Illuminate\Support\Facades\Validator; // ✅ ใช้ namespace ที่ถูกต้อง

class MedicalController extends Controller
{
    // แสดงฟอร์มเพิ่มข้อมูลใหม่
    public function MedicalAdd($client_id)
    {
        $client = Client::findOrFail($client_id);
        $medicals = Medical::where('client_id', $client->id)
            ->orderBy('medical_date', 'desc')
            ->get();

        return view('frontend.client.medical.medical_create', compact('client', 'client_id', 'medicals'));
    }

    // บันทึกข้อมูลใหม่
    public function MedicalStore(Request $request)
    {
        $data = $request->validate([
            'medical_date' => 'required|date',
            'disease_name' => 'required|string|max:255',
            'illness'      => 'required|string',
            'treatment'    => 'nullable|string',
            'refer'        => 'required|in:พบแพทย์,ไม่พบแพทย์',
            'diagnosis'    => 'nullable|string',
            'appt_date'    => 'nullable|date',
            'teacher'      => 'nullable|string|max:255',
            'remark'       => 'nullable|string',
            'client_id'    => 'required|exists:clients,id',
        ], [
            'medical_date.required' => 'กรุณาระบุวันที่รักษา',
            'medical_date.date'     => 'วันที่รักษาไม่ถูกต้อง',
            'disease_name.required' => 'กรุณาระบุชื่อโรค',
            'illness.required'      => 'กรุณาระบุอาการเจ็บป่วย',
            'refer.required'        => 'กรุณาเลือกการส่งต่อ',
        ]);

        if ($data['refer'] === 'ไม่พบแพทย์') {
            $data['diagnosis'] = null;
            $data['appt_date'] = null;
        }

        Medical::create($data);

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    // โหลดข้อมูลสำหรับแก้ไข (JSON)
    public function editMedicalJson($id)
    {
        $medical = Medical::findOrFail($id);

        return response()->json([
            'id'           => $medical->id,
            'medical_date' => $medical->medical_date ? \Carbon\Carbon::parse($medical->medical_date)->format('Y-m-d') : null,
            'disease_name' => $medical->disease_name,
            'illness'      => $medical->illness,
            'treatment'    => $medical->treatment,
            'refer'        => $medical->refer,
            'diagnosis'    => $medical->diagnosis,
            'appt_date'    => $medical->appt_date ? \Carbon\Carbon::parse($medical->appt_date)->format('Y-m-d') : null,
            'teacher'      => $medical->teacher,
            'remark'       => $medical->remark,
            'client_id'    => $medical->client_id,
        ]);
    }

    // อัปเดตข้อมูล
   public function MedicalUpdate(Request $request, $id)
{
    $medical = Medical::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'medical_date' => 'required|date',
        'disease_name' => 'required|string|max:255',
        'illness'      => 'required|string',
        'treatment'    => 'nullable|string',
        'refer'        => 'required|in:พบแพทย์,ไม่พบแพทย์',
        'diagnosis'    => 'nullable|string',
        'appt_date'    => 'nullable|date',
        'teacher'      => 'nullable|string|max:255',
        'remark'       => 'nullable|string',
        'client_id'    => 'required|exists:clients,id',
    ], [
        'medical_date.required' => 'กรุณาระบุวันที่รักษา',
        'medical_date.date'     => 'วันที่รักษาไม่ถูกต้อง',
        'disease_name.required' => 'กรุณาระบุชื่อโรค',
        'illness.required'      => 'กรุณาระบุอาการเจ็บป่วย',
        'refer.required'        => 'กรุณาเลือกการส่งต่อ',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput()
            ->with([
                'edit_mode' => true,
                'edit_id'   => $id,
            ]);
    }

    $data = $validator->validated();
    if ($data['refer'] === 'ไม่พบแพทย์') {
        $data['diagnosis'] = null;
        $data['appt_date'] = null;
    }

    $medical->update($data);

    // ✅ สำเร็จ → redirect ไปหน้าตาราง (เช่น medical.index)
   return redirect()->route('medical.add', $medical->client_id)
                 ->with('success', 'อัปเดตข้อมูลเรียบร้อย');
}

    // ลบข้อมูล
    public function MedicalDelete($id)
    {
        $medical   = Medical::findOrFail($id);
        $clientId  = $medical->client_id;
        $medical->delete();

        return redirect()->route('medical.add', $clientId)
                         ->with(['message' => 'ลบข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }
}