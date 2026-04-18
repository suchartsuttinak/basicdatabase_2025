<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\SchoolFollowup\StoreSchoolFollowupRequest;
use App\Http\Requests\Client\SchoolFollowup\UpdateSchoolFollowupRequest;
use App\Models\Client;
use App\Models\EducationRecord;
use App\Models\SchoolFollowup;
use Carbon\Carbon;
use Illuminate\Http\Request; // ✅ เพิ่มบรรทัดนี้

class SchoolFollowupController extends Controller
{
    public function SchoolFollowupAdd(Request $request, $client_id)
{
    $client = Client::forUser(auth()->user())->findOrFail($client_id);
    $educationRecord = $this->getLatestEducationRecord($client_id);

    if (!$educationRecord) {
        return redirect()
            ->route('education_record_add', $client_id)
            ->with('warning', 'กรุณาเพิ่มข้อมูลการศึกษาเด็กก่อนบันทึกการติดตาม');
    }

    // ✅ เพิ่ม filter
    $startDate = $request->filled('start_date')
        ? Carbon::parse($request->start_date)->startOfDay()
        : null;

    $endDate = $request->filled('end_date')
        ? Carbon::parse($request->end_date)->endOfDay()
        : null;

    $query = SchoolFollowup::with([
            'educationRecord.education',
            'educationRecord.semester'
        ])
        ->where('client_id', $client_id);

    if ($startDate) {
        $query->whereDate('follow_date', '>=', $startDate->toDateString());
    }

    if ($endDate) {
        $query->whereDate('follow_date', '<=', $endDate->toDateString());
    }

    $followups = $query
        ->orderByDesc('follow_date')
        ->orderByDesc('id')
        ->get();

    return view('frontend.client.school_followup.school_followup_create', compact(
        'client',
        'educationRecord',
        'client_id',
        'followups'
    ));
}

    public function SchoolFollowupStore(StoreSchoolFollowupRequest $request)
    {
        $validated = $request->validated();

        $client = Client::forUser(auth()->user()) // ✅ [แก้ไข]
            ->where('id', $validated['client_id'])
            ->firstOrFail();

        if (empty($validated['education_record_id'])) {
            $educationRecord = $this->getLatestEducationRecord($validated['client_id']);
            $validated['education_record_id'] = $educationRecord?->id;
        }

        $validated['client_id'] = $client->id; // ✅ [แก้ไข]

        SchoolFollowup::create($validated);

        return redirect()
            ->route('school_followup_add', $validated['client_id'])
            ->with([
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    public function SchoolFollowupEdit($id)
    {
        try {
            $followup = SchoolFollowup::with([
                    'educationRecord.education',
                    'educationRecord.semester'
                ])
                ->whereHas('client', function ($q) {
                    $q->forUser(auth()->user());
                })
                ->findOrFail($id); // ✅ [แก้ไข]

            $educationRecord = $followup->educationRecord;

            return response()->json([
                'success' => true,
                'message' => 'โหลดข้อมูลเรียบร้อยแล้ว',
                'data' => [
                    'id' => $followup->id,
                    'client_id' => $followup->client_id,
                    'education_record_id' => $followup->education_record_id,
                    'follow_date' => $followup->follow_date
                        ? Carbon::parse($followup->follow_date)->format('Y-m-d')
                        : null,
                    'teacher_name' => $followup->teacher_name,
                    'tel' => $followup->tel,
                    'follow_type' => $followup->follow_type,
                    'result' => $followup->result,
                    'remark' => $followup->remark,
                    'contact_name' => $followup->contact_name,
                    'school_name' => $educationRecord?->school_name ?? 'ไม่พบข้อมูล',
                    'education_name' => $educationRecord?->education?->education_name ?? 'ไม่พบข้อมูล',
                    'semester_name' => $educationRecord?->semester?->semester_name ?? 'ไม่พบข้อมูล',
                    'academic_year' => $educationRecord?->academic_year ?? 'ไม่พบข้อมูล',
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลการติดตามที่ต้องการแก้ไข',
                'errors' => [$e->getMessage()]
            ], 404);
        }
    }

    public function SchoolFollowupUpdate(UpdateSchoolFollowupRequest $request, $id)
    {
        $followup = SchoolFollowup::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->firstOrFail(); // ✅ [แก้ไข]

        $validated = $request->validated();

        // คง education_record_id เดิมไว้เสมอ
        $validated['education_record_id'] = $followup->education_record_id;
        $validated['client_id'] = $followup->client_id;

        $followup->update($validated);

        if ($request->ajax()) {
            $freshFollowup = $followup->fresh([
                'educationRecord.education',
                'educationRecord.semester'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                'data' => [
                    'id' => $freshFollowup->id,
                    'client_id' => $freshFollowup->client_id,
                    'education_record_id' => $freshFollowup->education_record_id,
                    'follow_date' => $freshFollowup->follow_date
                        ? Carbon::parse($freshFollowup->follow_date)->format('Y-m-d')
                        : null,
                    'teacher_name' => $freshFollowup->teacher_name,
                    'tel' => $freshFollowup->tel,
                    'follow_type' => $freshFollowup->follow_type,
                    'result' => $freshFollowup->result,
                    'remark' => $freshFollowup->remark,
                    'contact_name' => $freshFollowup->contact_name,
                    'school_name' => $freshFollowup->educationRecord?->school_name ?? 'ไม่พบข้อมูล',
                    'education_name' => $freshFollowup->educationRecord?->education?->education_name ?? 'ไม่พบข้อมูล',
                    'semester_name' => $freshFollowup->educationRecord?->semester?->semester_name ?? 'ไม่พบข้อมูล',
                    'academic_year' => $freshFollowup->educationRecord?->academic_year ?? 'ไม่พบข้อมูล',
                ]
            ]);
        }

        return redirect()
            ->route('school_followup_add', $followup->client_id)
            ->with([
                'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    public function SchoolFollowupDelete($id)
    {
        $followup = SchoolFollowup::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->firstOrFail(); // ✅ [แก้ไข]

        $clientId = $followup->client_id;

        $followup->delete();

        return redirect()
            ->route('school_followup_add', $clientId)
            ->with([
                'message' => 'ลบข้อมูลการติดตามเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    public function SchoolFollowupReport($followup_id)
    {
        $followup = SchoolFollowup::with([
                'educationRecord.education',
                'educationRecord.semester'
            ])
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->findOrFail($followup_id); // ✅ [แก้ไข]

        $client = Client::forUser(auth()->user())->findOrFail($followup->client_id); // ✅ [แก้ไข]
        $educationRecord = $followup->educationRecord;

        $age = $client->birth_date
            ? Carbon::parse($client->birth_date)->age
            : 'ไม่พบข้อมูล';

        return view('frontend.client.school_followup.school_followup_report', [
            'client' => $client,
            'educationRecord' => $educationRecord,
            'followup' => $followup,
            'school_name' => $educationRecord?->school_name ?? 'ไม่พบข้อมูล',
            'education_name' => $educationRecord?->education?->education_name ?? 'ไม่พบข้อมูล',
            'term' => $educationRecord?->semester?->semester_name ?? 'ไม่พบข้อมูล',
            'age' => $age,
        ]);
    }

    private function getLatestEducationRecord($clientId)
    {
        return EducationRecord::with(['education', 'semester'])
            ->where('client_id', $clientId)
            ->join('semesters', 'education_records.semester_id', '=', 'semesters.id')
            ->orderByRaw("
                CAST(SUBSTRING_INDEX(semesters.semester_name, '/', -1) AS UNSIGNED) DESC,
                CAST(SUBSTRING_INDEX(semesters.semester_name, '/', 1) AS UNSIGNED) DESC
            ")
            ->select('education_records.*')
            ->first();
    }

    public function SchoolFollowupReportRange(Request $request, $client_id)
{
    $client = Client::forUser(auth()->user())->findOrFail($client_id);

    $educationRecord = $this->getLatestEducationRecord($client_id);

    $startDate = $request->filled('start_date')
        ? Carbon::parse($request->start_date)->startOfDay()
        : null;

    $endDate = $request->filled('end_date')
        ? Carbon::parse($request->end_date)->endOfDay()
        : null;

    $query = SchoolFollowup::with([
            'educationRecord.education',
            'educationRecord.semester'
        ])
        ->where('client_id', $client_id);

    if ($startDate) {
        $query->whereDate('follow_date', '>=', $startDate->toDateString());
    }

    if ($endDate) {
        $query->whereDate('follow_date', '<=', $endDate->toDateString());
    }

    $followups = $query
        ->orderByDesc('follow_date')
        ->orderByDesc('id')
        ->get();

    $age = $client->birth_date
        ? Carbon::parse($client->birth_date)->age
        : 'ไม่พบข้อมูล';

    return view('frontend.client.school_followup.school_followup_report_range', [
        'client' => $client,
        'educationRecord' => $educationRecord,
        'followups' => $followups,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'age' => $age,
        'school_name' => optional($educationRecord)->school_name ?? '-',
        'education_name' => optional(optional($educationRecord)->education)->education_name ?? '-',
        'term' => optional(optional($educationRecord)->semester)->semester_name ?? '-',
    ]);
}
}