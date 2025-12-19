<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\EducationRecord;
use App\Models\SchoolFollowup;

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

        $followups = SchoolFollowup::where('client_id', $client_id)
            ->orderByDesc('follow_date')
            ->get();

        return view('frontend.client.school_followup.school_followup_create', [
            'client'          => $client,
            'educationRecord' => $educationRecord,
            'client_id'       => $client_id,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
            'followups'       => $followups,
        ]);
    }
 /**
     * บันทึกข้อมูลการติดตาม
     */
   public function SchoolFollowupStore(Request $request)
{
    $validated = $request->validate([
        'client_id'           => 'required|integer|exists:clients,id',
        'education_record_id' => 'nullable|integer', // ❌ ตัด exists ออก
        'follow_date'         => 'required|date',
        'teacher_name'        => 'nullable|string|max:255',
        'tel'                 => 'nullable|string|max:20',
        'follow_type'         => 'required|string|in:self,phone,other',
        'result'              => 'nullable|string',
        'remark'              => 'nullable|string',
        'contact_name'        => 'nullable|string|max:255',
        'follo_no'            => 'nullable|integer',
    ]);

    // ✅ ใช้ null แทน 0
    if (empty($validated['education_record_id'])) {
        $validated['education_record_id'] = null;
    }

    if (empty($validated['follo_no'])) {
        $lastNo = SchoolFollowup::where('client_id', $validated['client_id'])->max('follo_no');
        $validated['follo_no'] = ($lastNo ?? 0) + 1;
    }

    // Debug ดูค่าที่จะ insert
    // dd($validated);

    SchoolFollowup::create($validated);

    return redirect()
        ->route('school_followup_add', $request->client_id)
        ->with('success', 'บันทึกข้อมูลการติดตามเรียบร้อยแล้ว');
}
    /**
     * แสดงประวัติการติดตาม
     */
    public function SchoolFollowupShow($client_id)
    {
        $client = Client::findOrFail($client_id);

        $educationRecord = EducationRecord::with('education')
            ->where('client_id', $client_id)
            ->orderByDesc('record_date')
            ->first();

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

    /**
     * เปิดฟอร์มแก้ไขการติดตาม
     */
   public function SchoolFollowupEdit($id)
{
    $followup = SchoolFollowup::findOrFail($id);
    $client   = Client::findOrFail($followup->client_id);

    $educationRecord = EducationRecord::with('education')
        ->where('client_id', $client->id)
        ->orderByDesc('record_date')
        ->first();

    return view('frontend.client.school_followup.school_followup_create', [
        'followup'        => $followup,
        'client'          => $client,
        'educationRecord' => $educationRecord,
        'client_id'       => $client->id,
        'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
        'education_name'  => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
        'followups'       => SchoolFollowup::where('client_id', $client->id)
                                ->orderByDesc('follow_date')
                                ->get(),
    ]);
}

    /**
     * อัปเดตข้อมูลการติดตาม
     */
    public function SchoolFollowupUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'follow_date'  => 'required|date',
            'teacher_name' => 'nullable|string|max:255',
            'tel'          => 'nullable|string|max:20',
            'follow_type'  => 'required|string|in:self,phone,other',
            'result'       => 'nullable|string',
            'remark'       => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
        ]);

        $followup = SchoolFollowup::findOrFail($id);
        $followup->update($validated);

        return redirect()
            ->route('school_followup_add', $followup->client_id)
            ->with('success', 'แก้ไขข้อมูลการติดตามเรียบร้อยแล้ว');
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
            ->with('success', 'ลบข้อมูลการติดตามเรียบร้อยแล้ว');
    }
}