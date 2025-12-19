<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\EducationRecord;
use App\Models\SchoolFollowup; // ✅ import model

class SchoolFollowupController extends Controller
{
    /**
     * เปิดฟอร์มเพิ่มการติดตาม
     */
    public function SchoolFollowupAdd($client_id)
    {
        $client = Client::findOrFail($client_id);

        $educationRecord = EducationRecord::with('education')
            ->where('client_id', $client_id)
            ->orderByDesc('record_date')
            ->first();

        // ดึงประวัติการติดตามทั้งหมดของเด็ก
        $followups = SchoolFollowup::where('client_id', $client_id)
            ->orderByDesc('follow_date')
            ->get();

        return view('frontend.client.school_followup.school_followup_create', [
            'client'          => $client,
            'educationRecord' => $educationRecord, // อาจเป็น null ได้
            'client_id'       => $client_id,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
            'followups'       => $followups, // ✅ ส่งไปแสดงในตาราง
        ]);
    }

    /**
     * บันทึกข้อมูลการติดตาม
     */
    public function SchoolFollowupStore(Request $request)
    {
        $validated = $request->validate([
            'client_id'           => 'required|integer|exists:clients,id',
            'education_record_id' => 'nullable|integer|exists:education_records,id',
            'follow_date'         => 'required|date',
            'teacher_name'        => 'nullable|string|max:255',
            'tel'                 => 'nullable|string|max:20',
            'follow_type'         => 'required|string|in:self,phone,other',
            'result'              => 'nullable|string',
            'remark'              => 'nullable|string',
            'contact_name'        => 'nullable|string|max:255',
            'follo_no'            => 'nullable|integer',
        ]);

        // ✅ กำหนดค่า fallback
        if (empty($validated['education_record_id'])) {
            $validated['education_record_id'] = 0; // หรือสร้าง record ใหม่ก่อน
        }

        if (empty($validated['follo_no'])) {
            $validated['follo_no'] = (SchoolFollowup::max('follo_no') ?? 0) + 1;
        }

        SchoolFollowup::create($validated);

        return redirect()
            ->route('school_followup_add', $request->client_id) // ✅ ใช้ชื่อ route ที่ถูกต้อง
            ->with('success', 'บันทึกข้อมูลการติดตามเรียบร้อยแล้ว');
    }

    /**
     * แสดงประวัติการติดตาม (กรณีต้องการหน้าแยก)
     */
    public function SchoolFollowupShow($client_id)
    {
      $client = Client::findOrFail($client_id);

    $educationRecord = EducationRecord::with('education')
        ->where('client_id', $client_id)
        ->orderByDesc('record_date')
        ->first();

    // ✅ ดึง followups พร้อม educationRecord และ education
    $followups = SchoolFollowup::with(['educationRecord.education'])
        ->where('client_id', $client_id)
        ->orderByDesc('follow_date')
        ->get();

    return view('frontend.client.school_followup.school_followup_show', [
        'client'          => $client,
        'educationRecord' => $educationRecord,
        'followups'       => $followups,
    ]);


}
}