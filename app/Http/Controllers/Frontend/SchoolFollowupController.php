<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\EducationRecord;
use App\Models\SchoolFollowup;
use Carbon\Carbon;

class SchoolFollowupController extends Controller
{
    /**
     * เปิดฟอร์มเพิ่มการติดตาม
     */
    public function SchoolFollowupAdd($client_id)
    {
        $client = Client::findOrFail($client_id);

    $educationRecord = EducationRecord::with(['education','semester'])
        ->where('client_id', $client_id)
        ->join('semesters', 'education_records.semester_id', '=', 'semesters.id')
        ->orderByRaw("
            CAST(SUBSTRING_INDEX(semesters.semester_name, '/', -1) AS UNSIGNED) DESC,
            CAST(SUBSTRING_INDEX(semesters.semester_name, '/', 1) AS UNSIGNED) DESC
        ")
        ->select('education_records.*')
        ->first();

    if (!$educationRecord) {
        return redirect()->route('education_record_add', $client_id)
            ->with('warning', 'กรุณาเพิ่มข้อมูลการศึกษาเด็กก่อนบันทึกการติดตาม');
    }

    $followups = SchoolFollowup::with(['educationRecord.education','educationRecord.semester'])
        ->where('client_id', $client_id)
        ->orderByDesc('follow_date')
        ->get();

    return view('frontend.client.school_followup.school_followup_create', compact(
        'client','educationRecord','client_id','followups'
    ));
}

public function SchoolFollowupStore(Request $request)
{
   $validated = $request->validate([
    'client_id'           => 'required|integer|exists:clients,id',
    'education_record_id' => 'nullable|integer',
    'follow_date'         => 'required|date',
    'teacher_name'        => 'nullable|string|max:255',
    'tel'                 => 'nullable|string|max:20',
    'follow_type'         => 'required|string|in:self,phone,other',
    'result'              => 'required|string',
    'remark'              => 'nullable|string',
    'contact_name'        => 'required|string|max:255',
], [
    'client_id.required'    => 'กรุณาเลือกเด็กนักเรียน',
    'client_id.integer'     => 'รหัสนักเรียนต้องเป็นตัวเลข',
    'client_id.exists'      => 'ไม่พบข้อมูลนักเรียนที่เลือก',
    'follow_date.required'  => 'กรุณาระบุวันที่ติดตาม',
    'follow_date.date'      => 'วันที่ติดตามไม่ถูกต้อง',
    'follow_type.required'  => 'กรุณาเลือกวิธีการติดตาม',
    'follow_type.in'        => 'วิธีการติดตามไม่ถูกต้อง',
    'result.required'       => 'กรุณาระบุผลการติดตาม',
    'teacher_name.max'      => 'ชื่อครูต้องไม่เกิน 255 ตัวอักษร',
    'tel.max'               => 'เบอร์โทรศัพท์ต้องไม่เกิน 20 ตัวอักษร',
    'contact_name.max'      => 'ชื่อผู้ติดตามต้องไม่เกิน 255 ตัวอักษร',
    'contact_name.required' => 'กรุณาระบุชื่อผู้ติดตาม',
]);


    SchoolFollowup::create($validated);

    return redirect()->route('school_followup_add', $request->client_id)
        ->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
}

    /**
     * เปิดฟอร์มแก้ไขการติดตาม
     */
 public function SchoolFollowupEdit($id)
{
    try {
        $followup = SchoolFollowup::findOrFail($id);

        return response()->json([
            'success'      => true,
            'message'      => 'โหลดข้อมูลเรียบร้อยแล้ว',
            'data'         => [
                'id'           => $followup->id,
                'follow_date'  => \Carbon\Carbon::parse($followup->follow_date)->format('Y-m-d'),
                'teacher_name' => $followup->teacher_name,
                'tel'          => $followup->tel,
                'follow_type'  => $followup->follow_type,
                'result'       => $followup->result,
                'remark'       => $followup->remark,
                'contact_name' => $followup->contact_name,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่พบข้อมูลการติดตามที่ต้องการแก้ไข',
            'errors'  => [$e->getMessage()]
        ], 404);
    }
}
    /**
     * อัปเดตข้อมูลการติดตาม
     */
    public function SchoolFollowupUpdate(Request $request, $id)
{
    $followup = SchoolFollowup::findOrFail($id);

    $validated = $request->validate($this->rules(true), $this->messages());

     // ✅ ถ้า contact_name ว่าง → ใส่ค่า "ไม่ระบุข้อมูล"
    if (empty($validated['contact_name'])) {
        $validated['contact_name'] = 'ไม่ระบุข้อมูล';
    }



    $followup->update($validated);

    // ถ้าเป็น AJAX → ส่ง JSON กลับ
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
            'data'    => $followup
        ]);
    }

    // ถ้าไม่ใช่ AJAX → redirect กลับไปหน้า edit พร้อมข้อความ
    return redirect()->route('school_followup_add', $followup->client_id)
                     ->with(['message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
}

/**
 * Validation Rules
 */
private function rules($isUpdate = false)
{
    return [
        'client_id'           => $isUpdate ? 'sometimes|integer|exists:clients,id' : 'required|integer|exists:clients,id',
        'education_record_id' => 'nullable|integer',
        // 'follow_date'         => 'required|date|after_or_equal:today', // ✅ ต้องเป็นวันที่ปัจจุบันหรืออนาคต
        
          // ✅ อนุญาตให้ย้อนหลังได้
        'follow_date'         => 'required|date', 
        'teacher_name'        => 'nullable|string|max:255',
        'tel'                 => 'nullable|string|max:20',
        'follow_type'         => 'required|string|in:self,phone,other',
        'result'              => $isUpdate ? 'required|string|max:255' : 'required|string|max:255', // ✅ ต้องกรอกผลการติดตามเสมอ
        'remark'              => 'nullable|string',
        'contact_name'        => $isUpdate ? 'required|string|max:255' : 'required|string|max:255',
    ];
}

/**
 * Validation Messages
 */
private function messages()
{
    return [
        'client_id.required'    => 'กรุณาเลือกเด็กนักเรียน',
        'client_id.integer'     => 'รหัสนักเรียนต้องเป็นตัวเลข',
        'client_id.exists'      => 'ไม่พบข้อมูลนักเรียนที่เลือก',

        'follow_date.required'  => 'กรุณาระบุวันที่ติดตาม',
        'follow_date.date'      => 'วันที่ติดตามไม่ถูกต้อง',
        // 'follow_date.after_or_equal' => 'วันที่ติดตามต้องไม่ย้อนหลัง',

        'follow_type.required'  => 'กรุณาเลือกวิธีการติดตาม',
        'follow_type.in'        => 'วิธีการติดตามไม่ถูกต้อง',

        'result.required'       => 'กรุณาระบุผลการติดตาม',
        'result.max'            => 'ผลการติดตามต้องไม่เกิน 255 ตัวอักษร',

        'teacher_name.max'      => 'ชื่อครูต้องไม่เกิน 255 ตัวอักษร',
        'tel.max'               => 'เบอร์โทรศัพท์ต้องไม่เกิน 20 ตัวอักษร',

        'contact_name.required' => 'กรุณาระบุชื่อผู้ติดตาม',
        'contact_name.max'      => 'ชื่อผู้ติดตามต้องไม่เกิน 255 ตัวอักษร',
    ];
}
    /**
     * ลบข้อมูลการติดตาม
     */
    public function SchoolFollowupDelete($id)
    {
        $followup = SchoolFollowup::findOrFail($id);
        $clientId = $followup->client_id;

        $followup->delete();

        return redirect()
            ->route('school_followup_add', $clientId)
            ->with([
                'message' => 'ลบข้อมูลการติดตามเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }
    /**
     * รายงานการติดตาม
     */
    public function SchoolFollowupReport($followup_id)
    {
        $followup = SchoolFollowup::with(['educationRecord.education','educationRecord.semester'])
            ->findOrFail($followup_id);

        $client = Client::findOrFail($followup->client_id);

        $educationRecord = EducationRecord::with(['education','semester'])
            ->where('client_id', $client->id)
            ->join('semesters', 'education_records.semester_id', '=', 'semesters.id')
            ->orderByRaw("
                CAST(SUBSTRING_INDEX(semesters.semester_name, '/', -1) AS UNSIGNED) DESC,
                CAST(SUBSTRING_INDEX(semesters.semester_name, '/', 1) AS UNSIGNED) DESC
            ")
            ->select('education_records.*')
            ->first();

        $age = $client->birth_date
            ? Carbon::parse($client->birth_date)->age
            : 'ไม่พบข้อมูล';

        return view('frontend.client.school_followup.school_followup_report', [
            'client'          => $client,
            'educationRecord' => $educationRecord,
            'followup'        => $followup,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional($educationRecord->education)->education_name ?? 'ไม่พบข้อมูล',
            'term'            => optional($educationRecord->semester)->semester_name ?? 'ไม่พบข้อมูล',
            'age'             => $age,
        ]);
    }
}