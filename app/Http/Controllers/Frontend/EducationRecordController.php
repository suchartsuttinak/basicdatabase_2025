<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Subject;
use App\Models\Education;
use App\Models\EducationRecord; // ✅ ต้อง import
use Illuminate\Support\Facades\Validator; // ✅ ต้อง import validated


class EducationRecordController extends Controller
{
    public function EducationRecordAdd($client_Id)
    {
        $client = Client::findOrFail($client_Id);
        $subjects = Subject::all();
        $educations = Education::all();
        return view('frontend.client.education_record.education_record_create', compact('client','subjects', 'educations'));
    }

 public function EducationRecordStore(Request $request)
{
    $validated = $request->validate([
        'client_id'    => 'required|exists:clients,id',
        'education_id' => 'required|exists:education,id',
        'semester'     => 'required|string',
        'school_name'  => 'required|string',
        'record_date'  => 'required|date',
        'grade_average' => 'nullable|numeric|regex:/^\d{1,3}(\.\d{1,2})?$/',
        'subjects'     => 'required|array',
        'subjects.*.subject_id' => 'required|exists:subjects,id',
        'subjects.*.score'      => 'required|numeric|min:0|max:100',
        'subjects.*.grade'      => 'required|string',
    ]);

    // ✅ กันไม่ให้เลือก subject_id ซ้ำในฟอร์มเดียวกัน
    $subjectIds = array_column($validated['subjects'], 'subject_id');
    if (count($subjectIds) !== count(array_unique($subjectIds))) {
        return back()->with('error', 'ไม่สามารถเลือกวิชาเดิมซ้ำในฟอร์มเดียวกันได้');
    }

    // ✅ ตรวจสอบว่ามี record ภาคเรียนนี้ของนักเรียนคนนี้อยู่แล้วหรือไม่
    $existingRecord = EducationRecord::where('client_id', $validated['client_id'])
        ->where('education_id', $validated['education_id'])
        ->where('semester', $validated['semester'])
        ->first();

    if ($existingRecord) {
        return back()->with('error', 'มีการบันทึกผลการเรียนในภาคเรียนนี้แล้ว');
    }

    // ✅ สร้าง EducationRecord ใหม่ (ไม่ต้องมี subject_id)
    $record = EducationRecord::create([
        'client_id'    => $validated['client_id'],
        'education_id' => $validated['education_id'],
        'semester'     => $validated['semester'],
        'school_name'  => $validated['school_name'],
        'record_date'  => $validated['record_date'],
        'grade_average' => $validated['grade_average'] !== null 
            ? number_format($validated['grade_average'], 2, '.', '') 
            : null,
    ]);

    // ✅ แนบผลการเรียน (pivot table)
    foreach ($validated['subjects'] as $data) {
        $record->subjects()->attach($data['subject_id'], [
            'score' => $data['score'],
            'grade' => $data['grade'],
        ]);
    }

    return redirect()->route('education_record_show', ['client_id' => $validated['client_id']])
                     ->with('success','บันทึกผลการเรียนเรียบร้อยแล้ว');
}

    public function EducationRecordShow($client_Id)
{
    $client = Client::findOrFail($client_Id);

    // ดึงข้อมูลผลการเรียน พร้อมวิชา เรียงจากล่าสุดไปเก่า
    $educationRecords = EducationRecord::with('subjects')
        ->where('client_id', $client_Id)
        ->orderBy('record_date', 'desc') // ✅ เรียงลำดับล่าสุดอยู่บน
        ->get();

    if ($educationRecords->isEmpty()) {
        return redirect()->route('education_record.add', ['client_id' => $client_Id])
                         ->with('info', 'ยังไม่มีข้อมูลผลการเรียนสำหรับนักเรียนนี้');
    }

    $records = EducationRecord::with('education')->get();
    
    return view('frontend.client.education_record.education_record_show',
        compact('client', 'educationRecords', 'records'));
}

// ฟังก์ชันช่วยแปลงเกรดเป็นคะแนน
private function convertGradeToPoint($grade)
{
    return match ($grade) {
        'A'  => 4.00,
        'B+' => 3.50,
        'B'  => 3.00,
        'C+' => 2.50,
        'C'  => 2.00,
        'D+' => 1.50,
        'D'  => 1.00,
        'F'  => 0.00,
        default => null,
    };
}

       public function EducationRecordEdit($id)
{
    // ✅ ดึงข้อมูล EducationRecord พร้อม subjects (pivot)
    $record = EducationRecord::with('subjects')->findOrFail($id);

    // ✅ ดึงข้อมูล client ที่เกี่ยวข้อง
    $client = $record->client; // ใช้ relationship จะสั้นกว่า Client::findOrFail()

    // ✅ ดึงข้อมูลทั้งหมดของ subjects และ educations สำหรับ dropdown
    $subjects = Subject::all();
    $educations = Education::all();

    // ✅ ส่งข้อมูลไปยัง view
    return view('frontend.client.education_record.education_record_edit', compact(
        'record',
        'client',
        'subjects',
        'educations'
    ));
}

    public function EducationRecordUpdate(Request $request, $id)
{
    $validated = $request->validate([
        'client_id'    => 'required|exists:clients,id',
        'education_id' => 'required|exists:education,id',
        'semester'     => 'required|string',
        'school_name'  => 'required|string',
        'record_date'  => 'required|date',
        'grade_average'=> 'nullable|numeric|regex:/^\d{1,3}(\.\d{1,2})?$/',
        'subjects'     => 'required|array',
        'subjects.*.subject_id' => 'required|exists:subjects,id',
        'subjects.*.score'      => 'required|numeric|min:0|max:100',
        'subjects.*.grade'      => 'required|string',
    ]);

    // ✅ กันไม่ให้เลือก subject_id ซ้ำในฟอร์มเดียวกัน
    $subjectIds = array_column($validated['subjects'], 'subject_id');
    if (count($subjectIds) !== count(array_unique($subjectIds))) {
        return back()->with('error', 'ไม่สามารถเลือกวิชาเดิมซ้ำในฟอร์มเดียวกันได้');
    }

    // ✅ ดึง record ที่ต้องการแก้ไข
    $record = EducationRecord::findOrFail($id);

    // ✅ อัปเดตข้อมูลหลักของ EducationRecord
    $record->update([
        'client_id'    => $validated['client_id'],
        'education_id' => $validated['education_id'],
        'semester'     => $validated['semester'],
        'school_name'  => $validated['school_name'],
        'record_date'  => $validated['record_date'],
        'grade_average'=> $validated['grade_average'] !== null 
            ? number_format($validated['grade_average'], 2, '.', '') 
            : null,
    ]);

    // ✅ เตรียมข้อมูล subjects สำหรับ sync
    $syncData = [];
    foreach ($validated['subjects'] as $data) {
        $syncData[$data['subject_id']] = [
            'score' => $data['score'],
            'grade' => $data['grade'],
        ];
    }

    // ✅ อัปเดต pivot table (ลบ/เพิ่ม/แก้ไขให้ตรงกับข้อมูลใหม่)
    $record->subjects()->sync($syncData);

    return redirect()->route('education_record_show', ['client_id' => $validated['client_id']])
                     ->with('success','แก้ไขผลการเรียนเรียบร้อยแล้ว');

}
}