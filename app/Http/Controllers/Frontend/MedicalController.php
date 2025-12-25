<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Medical;

class MedicalController extends Controller
{
    // แสดงฟอร์มเพิ่มข้อมูลใหม่
    public function MedicalAdd($client_id)
    {
        $client = Client::findOrFail($client_id);
        $medicals = Medical::where('client_id', $client->id)
            ->orderBy('medical_date', 'desc')
            ->get();
        $medical = null; // สำหรับเพิ่มใหม่

        return view('frontend.client.medical.medical_create', compact('client', 'client_id', 'medicals', 'medical'));
    }

    // บันทึกข้อมูลใหม่
    public function MedicalStore(Request $request)
    {
        $data = $request->validate([
            'medical_date' => 'required|date',
            'disease_name' => 'nullable|string|max:255',
            'illness' => 'nullable|string',
            'treatment' => 'nullable|string',
            'refer' => 'required|in:พบแพทย์,ไม่พบแพทย์',
            'diagnosis' => 'nullable|string',
            'appt_date' => 'nullable|date',
            'teacher' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'client_id' => 'required|exists:clients,id',
        ]);

        if ($data['refer'] === 'ไม่พบแพทย์') {
            $data['diagnosis'] = null;
            $data['appt_date'] = null;
        }

        Medical::create($data);

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    // แก้ไขข้อมูล (โหลดฟอร์มพร้อมข้อมูลเดิม)
    public function Medicaledit($id)
    {
        $medical = Medical::findOrFail($id);
        $client = $medical->client;
        $medicals = Medical::where('client_id', $client->id)
            ->orderBy('medical_date', 'desc')
            ->get();

        return view('frontend.client.medical.medical_create', compact('client', 'medicals', 'medical'));
    }

    // อัปเดตข้อมูล
   public function MedicalUpdate(Request $request, $id)
{
    $medical = Medical::findOrFail($id);

    $data = $request->validate([
        'medical_date' => 'required|date',
        'disease_name' => 'nullable|string|max:255',
        'illness' => 'nullable|string',
        'treatment' => 'nullable|string',
        'refer' => 'required|in:พบแพทย์,ไม่พบแพทย์',
        'diagnosis' => 'nullable|string',
        'appt_date' => 'nullable|date',
        'teacher' => 'nullable|string|max:255',
        'remark' => 'nullable|string',
    ]);

    if ($data['refer'] === 'ไม่พบแพทย์') {
        $data['diagnosis'] = null;
        $data['appt_date'] = null;
    }

    $medical->update($data);

    return redirect()->route('medical.add', $medical->client_id)
                     ->with('success', 'อัปเดตข้อมูลเรียบร้อย');
}



    // ลบข้อมูล
    public function MedicalDelete($id)
    {
        $medical   = Medical::findOrFail($id);
        $clientId = $medical->client_id;
        $medical->delete();

        return redirect()
            ->route('medical.add', $clientId)
            ->with(['message' => 'ลบข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }
}