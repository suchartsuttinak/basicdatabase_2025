<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Client;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VaccinationController extends Controller
{
     // แสดงรายการวัคซีนของ client
    public function VaccineShow($client_id)
    {
        $client = Client::findOrFail($client_id);
        $vaccinations = $client->vaccinations()->latest('date')->get();
        return view('frontend.client.vaccine.vaccine_show', compact('client', 'vaccinations'));
    }

    // บันทึกข้อมูลวัคซีนใหม่
    public function VaccineStore(Request $request)
    {
       $validated = $request->validate([
            'client_id'    => 'required|integer',
            'date'         => 'required|date',
            'vaccine_name' => 'required|string|max:255',
            'hospital'     => 'nullable|string|max:255',
            'recorder'     => 'nullable|string|max:255',
            'remark'       => 'nullable|string|max:500',
        ], [
            'client_id.required'    => 'กรุณาระบุรหัสผู้รับบริการ',
            'date.required'         => 'กรุณากรอกวันที่รับวัคซีน',
            'date.date'             => 'วันที่รับวัคซีนไม่ถูกต้อง',
            'vaccine_name.required' => 'กรุณากรอกชนิดวัคซีน',
            'vaccine_name.max'      => 'ชนิดวัคซีนต้องไม่เกิน 255 ตัวอักษร',
            'hospital.max'          => 'ชื่อสถานพยาบาลต้องไม่เกิน 255 ตัวอักษร',
            'recorder.max'          => 'ชื่อเจ้าหน้าที่ต้องไม่เกิน 255 ตัวอักษร',
            'remark.max'            => 'หมายเหตุต้องไม่เกิน 500 ตัวอักษร',
        ]);



        Vaccination::create($validated);

          $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );

        return redirect()->route('vaccine.index', $validated['client_id'])
                         ->with($notification);
    }

    // ดึงข้อมูลวัคซีนมาแก้ไข (ใช้กับ AJAX Modal)
    public function VaccineEdit($id)
    {
        $vaccination = Vaccination::findOrFail($id);
        return response()->json($vaccination);
    }

    // อัปเดตข้อมูลวัคซีน
    public function VaccineUpdate(Request $request, $id)
    {
        $vaccination = Vaccination::findOrFail($id);

        $validated = $request->validate([
            'date'         => 'required|date',
            'vaccine_name' => 'required|string|max:255',
            'hospital'     => 'nullable|string|max:255',
            'recorder'     => 'nullable|string|max:255',
            'remark'       => 'nullable|string|max:500',
        ], [
            'date.required'         => 'กรุณากรอกวันที่รับวัคซีน',
            'date.date'             => 'วันที่รับวัคซีนไม่ถูกต้อง',
            'vaccine_name.required' => 'กรุณากรอกชนิดวัคซีน',
            'vaccine_name.max'      => 'ชนิดวัคซีนต้องไม่เกิน 255 ตัวอักษร',
            'hospital.max'          => 'ชื่อสถานพยาบาลต้องไม่เกิน 255 ตัวอักษร',
            'recorder.max'          => 'ชื่อเจ้าหน้าที่ต้องไม่เกิน 255 ตัวอักษร',
            'remark.max'            => 'หมายเหตุต้องไม่เกิน 500 ตัวอักษร',
        ]);



        $vaccination->update($validated);

         $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->route('vaccine.index', $vaccination->client_id)
                         ->with($notification);
    }

    // ลบข้อมูลวัคซีน
    public function VaccineDelete($id)
    {
        $vaccination = Vaccination::findOrFail($id);
        $client_id = $vaccination->client_id;
        $vaccination->delete();

        return redirect()->route('vaccine.index', $client_id)
                         ->with('success', 'ลบข้อมูลวัคซีนเรียบร้อยแล้ว');
    }
}

