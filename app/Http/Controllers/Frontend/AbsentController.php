<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\EducationRecord;
use App\Models\Absent;
use Carbon\Carbon;

class AbsentController extends Controller
{
    /** เปิดฟอร์มเพิ่มการขาดเรียน */
    public function AbsentAdd($client_id)
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
            return redirect()->route('education_record.add', $client_id)
                ->with([
                    'message' => 'กรุณาเพิ่มข้อมูลการศึกษาเด็กก่อนบันทึกการขาดเรียน',
                    'alert-type' => 'warning'
                ]);
        }

        $absents = Absent::where('client_id', $client_id)
            ->orderByDesc('absent_date')
            ->get();

        return view('frontend.client.absent.absent_create', [
            'client'          => $client,
            'educationRecord' => $educationRecord,
            'client_id'       => $client_id,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional($educationRecord->education)->education_name ?? 'ไม่พบข้อมูล',
            'term'            => optional($educationRecord->semester)->semester_name ?? 'ไม่พบข้อมูล',
            'absents'         => $absents,
            'absent'          => null,
        ]);
    }

    /** บันทึกข้อมูลการขาดเรียน */
    public function AbsentStore(Request $request)
{
    $validated = $request->validate([
        'client_id'           => 'required|integer|exists:clients,id',
        'education_record_id' => 'nullable|integer',
        'absent_date'         => 'required|date',
        'record_date'         => 'required|date',
        'cause'               => 'required|string|max:255',
        'operation'           => 'nullable|string|max:255',
        'remark'              => 'nullable|string|max:500',
        'teacher'             => 'required|string|max:255',
    ], [
        'client_id.required'       => 'กรุณาระบุรหัสเด็ก',
        'client_id.integer'        => 'รหัสเด็กต้องเป็นตัวเลข',
        'client_id.exists'         => 'ไม่พบข้อมูลเด็กในระบบ',

        'absent_date.required'     => 'กรุณาเลือกวันที่ขาดเรียน',
        'absent_date.date'         => 'รูปแบบวันที่ขาดเรียนไม่ถูกต้อง',

        'record_date.required'     => 'กรุณาเลือกวันที่บันทึกข้อมูล',
        'record_date.date'         => 'รูปแบบวันที่บันทึกไม่ถูกต้อง',

        'cause.required'           => 'กรุณาระบุสาเหตุที่ขาดเรียน',
        'cause.string'             => 'สาเหตุที่ขาดเรียนต้องเป็นข้อความ',
        'cause.max'                => 'สาเหตุที่ขาดเรียนต้องไม่เกิน 255 ตัวอักษร',

        'operation.string'         => 'การดำเนินงานต้องเป็นข้อความ',
        'operation.max'            => 'การดำเนินงานต้องไม่เกิน 255 ตัวอักษร',

        'remark.string'            => 'หมายเหตุต้องเป็นข้อความ',
        'remark.max'               => 'หมายเหตุต้องไม่เกิน 500 ตัวอักษร',

        'teacher.required'         => 'กรุณากรอกชื่อผู้ดูแลเด็ก',
        'teacher.string'           => 'ชื่อผู้ดูแลเด็กต้องเป็นข้อความ',
        'teacher.max'              => 'ชื่อผู้ดูแลเด็กต้องไม่เกิน 255 ตัวอักษร',
    ]);

    // ✅ ตั้งค่า default วันที่ปัจจุบันอัตโนมัติ หากไม่ได้ส่งมา
    $validated['absent_date'] = $validated['absent_date'] ?? now()->format('Y-m-d');
    $validated['record_date'] = $validated['record_date'] ?? now()->format('Y-m-d');
    $validated['education_record_id'] = $validated['education_record_id'] ?: null;

    Absent::create($validated);

    // ✅ ส่งกลับพร้อม flash message แต่ไม่ส่ง input กลับ
    return back()->with([
        'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
        'alert-type' => 'success'
    ]);
}
    /** แสดงรายงานการขาดเรียน */
    public function AbsentReport($absent_id)
    {
        $absent = Absent::with(['educationRecord.education','educationRecord.semester'])
            ->findOrFail($absent_id);

        $client = Client::findOrFail($absent->client_id);

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

        return view('frontend.client.absent.absent_report', [
            'client'          => $client,
            'educationRecord' => $educationRecord,
            'absent'          => $absent,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional($educationRecord->education)->education_name ?? 'ไม่พบข้อมูล',
            'term'            => optional($educationRecord->semester)->semester_name ?? 'ไม่พบข้อมูล',
            'age'             => $age,
        ]);
    }

    /** เปิดฟอร์มแก้ไขการขาดเรียน */
   // ✅ คืนค่า JSON สำหรับ AJAX
public function AbsentEdit($id)
{
    $absent = Absent::findOrFail($id);

    return response()->json([
        'id'          => $absent->id,
        'absent_date' => \Carbon\Carbon::parse($absent->absent_date)->format('Y-m-d'),
        'record_date' => \Carbon\Carbon::parse($absent->record_date)->format('Y-m-d'),
        'cause'       => $absent->cause,
        'operation'   => $absent->operation,
        'remark'      => $absent->remark,
        'teacher'     => $absent->teacher,
    ]);
}

// ✅ คืนค่า view สำหรับหน้าเต็ม (ถ้าคุณยังต้องใช้)
public function AbsentEditView($id)
{
    $absent = Absent::findOrFail($id);
    $client = Client::findOrFail($absent->client_id);

    $educationRecord = EducationRecord::with(['education','semester'])
        ->where('client_id', $client->id)
        ->join('semesters', 'education_records.semester_id', '=', 'semesters.id')
        ->orderByRaw("
            CAST(SUBSTRING_INDEX(semesters.semester_name, '/', -1) AS UNSIGNED) DESC,
            CAST(SUBSTRING_INDEX(semesters.semester_name, '/', 1) AS UNSIGNED) DESC
        ")
        ->select('education_records.*')
        ->first();

    return view('frontend.client.absent.absent_create', [
        'absent'          => $absent,
        'client'          => $client,
        'educationRecord' => $educationRecord,
        'client_id'       => $client->id,
        'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
        'education_name'  => optional($educationRecord->education)->education_name ?? 'ไม่พบข้อมูล',
        'term'            => optional($educationRecord->semester)->semester_name ?? 'ไม่พบข้อมูล',
        'absents'         => Absent::where('client_id', $client->id)
                                ->orderByDesc('absent_date')
                                ->get(),
    ]);
}

    /** อัปเดตข้อมูลการขาดเรียน */
    public function AbsentUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id'           => 'required|integer|exists:clients,id',
            'education_record_id' => 'nullable|integer',
            'absent_date'         => 'required|date',
            'cause'               => 'nullable|string|max:255',
            'operation'           => 'nullable|string|max:255',
            'remark'              => 'nullable|string|max:500',
            'record_date'         => 'required|date',
            'teacher'             => 'nullable|string|max:255'
        ]);

        $absent = Absent::findOrFail($id);
        $absent->update($validated);

        return redirect()
            ->route('absent.add', $absent->client_id)
            ->with([
                'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    /** ลบข้อมูลการขาดเรียน */
    public function AbsentDelete($id)
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
}