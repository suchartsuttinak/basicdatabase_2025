<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Client;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VaccinationController extends Controller
{
    // ✅ แสดงรายการวัคซีนของ client
    public function VaccineShow($client_id)
    {
        // =========================
        // PATCH: กันเดา URL เข้าถึง client ที่ไม่มีสิทธิ์
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($client_id);

        $vaccinations = $client->vaccinations()->latest('date')->get();

        return view('frontend.client.vaccine.vaccine_show', compact('client', 'vaccinations'));
    }

    // ✅ บันทึกข้อมูลวัคซีนใหม่
    public function VaccineStore(Request $request)
    {
        $validated = $request->validate([
            'client_id'    => ['required', 'integer', 'exists:clients,id'],
            'date'         => [
                'required',
                'date',
                Rule::unique('vaccinations')->where(fn($query) => 
                    $query->where('client_id', $request->client_id)
                ),
            ],
            'vaccine_name' => 'required|string|max:255',
            'hospital'     => 'nullable|string|max:255',
            'recorder'     => 'nullable|string|max:255',
            'remark'       => 'nullable|string|max:500',
        ], [
            'client_id.required'    => 'กรุณาระบุรหัสผู้รับบริการ',
            'client_id.exists'      => 'รหัสผู้รับบริการไม่ถูกต้อง',
            'date.required'         => 'กรุณากรอกวันที่รับวัคซีน',
            'date.date'             => 'วันที่รับวัคซีนไม่ถูกต้อง',
            'date.unique'           => 'เด็กคนนี้มีการบันทึกวันที่รับวัคซีนนี้แล้ว',
            'vaccine_name.required' => 'กรุณากรอกชนิดวัคซีน',
            'vaccine_name.max'      => 'ชนิดวัคซีนต้องไม่เกิน 255 ตัวอักษร',
            'hospital.max'          => 'ชื่อสถานพยาบาลต้องไม่เกิน 255 ตัวอักษร',
            'recorder.max'          => 'ชื่อเจ้าหน้าที่ต้องไม่เกิน 255 ตัวอักษร',
            'remark.max'            => 'หมายเหตุต้องไม่เกิน 500 ตัวอักษร',
        ]);

        // =========================
        // PATCH: กันยิง request เปลี่ยน client_id
        // =========================
        Client::forUser(auth()->user())->findOrFail($validated['client_id']);

        Vaccination::create($validated);

        return redirect()->route('vaccine.index', $validated['client_id'])
                         ->with(['message' => 'บันทึกข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }

    // ✅ ดึงข้อมูลวัคซีนมาแก้ไข (ใช้กับ AJAX Modal)
    public function VaccineEdit($id)
    {
        $vaccination = Vaccination::findOrFail($id);

        // =========================
        // PATCH: กันเดา URL เรียกข้อมูลของ client คนอื่น
        // =========================
        Client::forUser(auth()->user())->findOrFail($vaccination->client_id);

        return response()->json([
            'id'           => $vaccination->id,
            'date'         => $vaccination->date,
            'vaccine_name' => $vaccination->vaccine_name,
            'hospital'     => $vaccination->hospital ?? 'ไม่ระบุ',
            'remark'       => $vaccination->remark ?? '',
            'recorder'     => $vaccination->recorder ?? '',
            'client_id'    => $vaccination->client_id,
        ]);
    }

    // ✅ อัปเดตข้อมูลวัคซีน
    public function VaccineUpdate(Request $request, $id)
    {
        $vaccination = Vaccination::findOrFail($id);

        // =========================
        // PATCH: กันเดา URL มา update record คนอื่น
        // =========================
        Client::forUser(auth()->user())->findOrFail($vaccination->client_id);

        $validator = Validator::make($request->all(), [
            'client_id'    => ['required', 'integer', 'exists:clients,id'],
            'date'         => [
                'required',
                'date',
                Rule::unique('vaccinations')
                    ->where(fn($query) => $query->where('client_id', $request->client_id))
                    ->ignore($vaccination->id, 'id'),
            ],
            'vaccine_name' => 'required|string|max:255',
            'hospital'     => 'nullable|string|max:255',
            'recorder'     => 'nullable|string|max:255',
            'remark'       => 'nullable|string|max:500',
        ], [
            'client_id.required'    => 'กรุณาระบุรหัสผู้รับบริการ',
            'client_id.exists'      => 'รหัสผู้รับบริการไม่ถูกต้อง',
            'date.required'         => 'กรุณากรอกวันที่รับวัคซีน',
            'date.date'             => 'วันที่รับวัคซีนไม่ถูกต้อง',
            'date.unique'           => 'เด็กคนนี้มีการบันทึกวันที่รับวัคซีนนี้แล้ว',
            'vaccine_name.required' => 'กรุณากรอกชนิดวัคซีน',
            'vaccine_name.max'      => 'ชนิดวัคซีนต้องไม่เกิน 255 ตัวอักษร',
            'hospital.max'          => 'ชื่อสถานพยาบาลต้องไม่เกิน 255 ตัวอักษร',
            'recorder.max'          => 'ชื่อเจ้าหน้าที่ต้องไม่เกิน 255 ตัวอักษร',
            'remark.max'            => 'หมายเหตุต้องไม่เกิน 500 ตัวอักษร',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with(['edit_mode' => true, 'edit_id' => $id]);
        }

        $data = $validator->validated();

        // =========================
        // PATCH: กันเปลี่ยน client_id ไป client อื่น
        // =========================
        Client::forUser(auth()->user())->findOrFail($data['client_id']);

        $vaccination->update($data);

        return redirect()->route('vaccine.index', $vaccination->client_id)
                         ->with(['message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }

    // ✅ ลบข้อมูลวัคซีน
    public function VaccineDelete($id)
    {
        $vaccination = Vaccination::findOrFail($id);

        // =========================
        // PATCH: กันเดา URL มาลบข้อมูลของ client คนอื่น
        // =========================
        Client::forUser(auth()->user())->findOrFail($vaccination->client_id);

        $client_id = $vaccination->client_id;
        $vaccination->delete();

        return redirect()->route('vaccine.index', $client_id)
                         ->with(['message' => 'ลบข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }
}