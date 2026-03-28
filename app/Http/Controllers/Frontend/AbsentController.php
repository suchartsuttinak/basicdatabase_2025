<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Absent\StoreAbsentRequest;
use App\Http\Requests\Client\Absent\UpdateAbsentRequest;
use App\Models\Absent;
use App\Models\Client;
use App\Models\EducationRecord;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AbsentController extends Controller
{
    public function AbsentAdd($client_id): View|RedirectResponse
    {
        $client = Client::findOrFail($client_id);
        $educationRecord = $this->getLatestEducationRecord($client_id);

        if (!$educationRecord) {
            return redirect()
                ->route('education_record.add', $client_id)
                ->with([
                    'message' => 'กรุณาเพิ่มข้อมูลการศึกษาเด็กก่อนบันทึกการขาดเรียน',
                    'alert-type' => 'warning',
                ]);
        }

        $absents = Absent::with(['educationRecord.education', 'educationRecord.semester'])
            ->where('client_id', $client_id)
            ->orderByDesc('absent_date')
            ->orderByDesc('id')
            ->get();

        return view('frontend.client.absent.absent_create', compact(
            'client',
            'educationRecord',
            'client_id',
            'absents'
        ));
    }

    public function AbsentStore(StoreAbsentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // ยึดหลักเดียวกับ school_followup:
        // ต้องมี education_record_id ของช่วงเวลานั้นติดไปกับ record นี้
        if (empty($validated['education_record_id'])) {
            $educationRecord = $this->getLatestEducationRecord($validated['client_id']);
            $validated['education_record_id'] = $educationRecord?->id;
        }

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
                ->findOrFail($id);

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

                    // ข้อมูลการศึกษาของ record นี้
                    'school_name' => optional($absent->educationRecord)->school_name ?? 'ไม่พบข้อมูล',
                    'education_name' => optional(optional($absent->educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
                    'semester_name' => optional(optional($absent->educationRecord)->semester)->semester_name ?? 'ไม่พบข้อมูล',
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
        $absent = Absent::findOrFail($id);
        $validated = $request->validated();

        // สำคัญ: คง education_record_id เดิมของ record นี้ไว้
        // เพื่อไม่ให้บันทึกเก่าถูกย้ายไปภาคเรียน/ปีการศึกษาใหม่
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
        $absent = Absent::findOrFail($id);
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
            ->findOrFail($absent_id);

        $client = Client::findOrFail($absent->client_id);

        // ใช้ข้อมูลการศึกษาที่ผูกอยู่กับ absent record นี้
        $educationRecord = $absent->educationRecord;

        $age = $client->birth_date
            ? Carbon::parse($client->birth_date)->age
            : 'ไม่พบข้อมูล';

        return view('frontend.client.absent.absent_report', [
            'client' => $client,
            'educationRecord' => $educationRecord,
            'absent' => $absent,
            'school_name' => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name' => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
            'term' => optional(optional($educationRecord)->semester)->semester_name ?? 'ไม่พบข้อมูล',
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
}