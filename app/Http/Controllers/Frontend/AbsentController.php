<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Absent\StoreAbsentRequest;
use App\Http\Requests\Client\Absent\UpdateAbsentRequest;
use App\Models\Absent;
use App\Models\Client;
use App\Models\EducationRecord;
use App\Models\Semester; // ✅ [เพิ่ม] ใช้ดึงชื่อภาคเรียนจาก semester_id โดยตรง
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsentController extends Controller
{
    public function AbsentAdd(Request $request, $client_id): View|RedirectResponse
    {
        $client = Client::forUser(auth()->user())->findOrFail($client_id); // ✅ [แก้ไข]
        $educationRecord = $this->getLatestEducationRecord($client_id);

        if (!$educationRecord) {
            return redirect()
                ->route('education_record.add', $client_id)
                ->with([
                    'message' => 'กรุณาเพิ่มข้อมูลการศึกษาเด็กก่อนบันทึกการขาดเรียน',
                    'alert-type' => 'warning',
                ]);
        }

        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : null;

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : null;

        $absentsQuery = Absent::with(['educationRecord.education', 'educationRecord.semester'])
            ->where('client_id', $client_id);

        if ($startDate) {
            $absentsQuery->whereDate('absent_date', '>=', $startDate->toDateString());
        }

        if ($endDate) {
            $absentsQuery->whereDate('absent_date', '<=', $endDate->toDateString());
        }

        $absents = $absentsQuery
            ->orderByDesc('absent_date')
            ->orderByDesc('id')
            ->get();

        // ✅ [เพิ่ม] เตรียมข้อมูลด้านซ้ายของ Modal หน้าเพิ่ม
        $schoolName = $educationRecord?->school_name ?? 'ไม่พบข้อมูล';
        $educationName = optional($educationRecord?->education)->education_name ?? 'ไม่พบข้อมูล';
        $semesterName = $this->getSemesterNameByEducationRecord($educationRecord); // ✅ [เพิ่ม] ดึงภาคเรียนแบบเสถียร

        return view('frontend.client.absent.absent_create', compact(
            'client',
            'educationRecord',
            'client_id',
            'absents',
            'schoolName',      // ✅ [เพิ่ม]
            'educationName',   // ✅ [เพิ่ม]
            'semesterName'     // ✅ [เพิ่ม]
        ));
    }

    public function AbsentStore(StoreAbsentRequest $request): RedirectResponse
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

        Absent::create($validated);

        return redirect()
            ->route('absent.add', $validated['client_id'])
            ->with([
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    public function AbsentEdit($id): JsonResponse
    {
        try {
            $absent = Absent::with(['educationRecord.education', 'educationRecord.semester'])
                ->whereHas('client', function ($q) {
                    $q->forUser(auth()->user());
                })
                ->findOrFail($id); // ✅ [แก้ไข]

            $educationRecord = $absent->educationRecord;

            // ✅ [แก้ไข] ดึงภาคเรียนจาก semester_id โดยตรง กัน relation ไม่มา
            $semesterName = $this->getSemesterNameByEducationRecord($educationRecord);

            return response()->json([
                'success' => true,
                'message' => 'โหลดข้อมูลเรียบร้อยแล้ว',
                'data' => [
                    'id' => $absent->id,
                    'client_id' => $absent->client_id,
                    'education_record_id' => $absent->education_record_id,
                    'absent_date' => $absent->absent_date
                        ? Carbon::parse($absent->absent_date)->format('Y-m-d')
                        : null,
                    'record_date' => $absent->record_date
                        ? Carbon::parse($absent->record_date)->format('Y-m-d')
                        : null,
                    'cause' => $absent->cause,
                    'operation' => $absent->operation,
                    'remark' => $absent->remark,
                    'teacher' => $absent->teacher,

                    'school_name' => $educationRecord?->school_name ?? 'ไม่พบข้อมูล',
                    'education_name' => optional($educationRecord?->education)->education_name ?? 'ไม่พบข้อมูล',
                    'semester_name' => $semesterName, // ✅ [แก้ไข]
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลการขาดเรียนที่ต้องการแก้ไข',
                'errors' => [$e->getMessage()]
            ], 404);
        }
    }

    public function AbsentUpdate(UpdateAbsentRequest $request, $id): JsonResponse|RedirectResponse
    {
        $absent = Absent::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->firstOrFail(); // ✅ [แก้ไข]

        $validated = $request->validated();

        $validated['education_record_id'] = $absent->education_record_id;

        $absent->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                'data' => $absent->fresh(['educationRecord.education', 'educationRecord.semester'])
            ]);
        }

        return redirect()
            ->route('absent.add', $absent->client_id)
            ->with([
                'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    public function AbsentDelete($id): RedirectResponse
    {
        $absent = Absent::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->firstOrFail(); // ✅ [แก้ไข]

        $clientId = $absent->client_id;

        $absent->delete();

        return redirect()
            ->route('absent.add', $clientId)
            ->with([
                'message' => 'ลบข้อมูลการขาดเรียนเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    public function AbsentReport($absent_id): View
    {
        $absent = Absent::with(['educationRecord.education', 'educationRecord.semester'])
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->findOrFail($absent_id); // ✅ [แก้ไข]

        $client = Client::forUser(auth()->user())->findOrFail($absent->client_id); // ✅ [แก้ไข]

        $educationRecord = $absent->educationRecord;

        $age = $client->birth_date
            ? Carbon::parse($client->birth_date)->age
            : 'ไม่พบข้อมูล';

        return view('frontend.client.absent.absent_report', [
            'client' => $client,
            'educationRecord' => $educationRecord,
            'absent' => $absent,
            'school_name' => $educationRecord?->school_name ?? 'ไม่พบข้อมูล',
            'education_name' => optional($educationRecord?->education)->education_name ?? 'ไม่พบข้อมูล',
            'term' => $this->getSemesterNameByEducationRecord($educationRecord), // ✅ [แก้ไข]
            'age' => $age,
        ]);
    }

    public function AbsentReportRange(Request $request, $client_id): View
    {
        $client = Client::forUser(auth()->user())->findOrFail($client_id); // ✅ [SECURITY]

        $educationRecord = $this->getLatestEducationRecord($client_id);

        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : null;

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : null;

        $query = Absent::with(['educationRecord.education', 'educationRecord.semester'])
            ->where('client_id', $client_id);

        if ($startDate) {
            $query->whereDate('absent_date', '>=', $startDate->toDateString());
        }

        if ($endDate) {
            $query->whereDate('absent_date', '<=', $endDate->toDateString());
        }

        $absents = $query
            ->orderByDesc('absent_date')
            ->orderByDesc('id')
            ->get();

        $age = $client->birth_date
            ? Carbon::parse($client->birth_date)->age
            : 'ไม่พบข้อมูล';

        return view('frontend.client.absent.absent_report_range', [
            'client' => $client,
            'educationRecord' => $educationRecord,
            'absents' => $absents,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'age' => $age,
            'school_name' => $educationRecord?->school_name ?? 'ไม่พบข้อมูล',
            'education_name' => optional($educationRecord?->education)->education_name ?? 'ไม่พบข้อมูล',
            'term' => $this->getSemesterNameByEducationRecord($educationRecord), // ✅ [แก้ไข]
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

    // ✅ [เพิ่ม] ใช้ซ้ำทุกจุดที่ต้องแสดงภาคเรียน เพื่อลดปัญหา relation ไม่มา
    private function getSemesterNameByEducationRecord($educationRecord): string
    {
        if (!$educationRecord || !$educationRecord->semester_id) {
            return 'ไม่พบข้อมูล';
        }

        return Semester::where('id', $educationRecord->semester_id)
            ->value('semester_name') ?? 'ไม่พบข้อมูล';
    }
}