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
        'result'              => 'nullable|string',
        'remark'              => 'nullable|string',
        'contact_name'        => 'nullable|string|max:255',
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
        $followup = SchoolFollowup::findOrFail($id);
        $client   = Client::findOrFail($followup->client_id);

        $educationRecord = EducationRecord::with(['education','semester'])
            ->where('client_id', $client->id)
            ->join('semesters', 'education_records.semester_id', '=', 'semesters.id')
            ->orderByRaw("
                CAST(SUBSTRING_INDEX(semesters.semester_name, '/', -1) AS UNSIGNED) DESC,
                CAST(SUBSTRING_INDEX(semesters.semester_name, '/', 1) AS UNSIGNED) DESC
            ")
            ->select('education_records.*')
            ->first();

        return view('frontend.client.school_followup.school_followup_create', [
            'followup'        => $followup,
            'client'          => $client,
            'educationRecord' => $educationRecord,
            'client_id'       => $client->id,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional($educationRecord->education)->education_name ?? 'ไม่พบข้อมูล',
            'term'            => optional($educationRecord->semester)->semester_name ?? 'ไม่พบข้อมูล',
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
            ->with([
                'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
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