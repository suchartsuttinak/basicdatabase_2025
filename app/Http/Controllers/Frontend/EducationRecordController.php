<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Subject;
use App\Models\Education;
use App\Models\EducationRecord;

class EducationRecordController extends Controller
{
    public function EducationRecordAdd($client_id)
    {
        $client = Client::findOrFail($client_id);
        $subjects = Subject::all();
        $educations = Education::all();
        return view('frontend.client.education_record.education_record_create', compact('client','subjects', 'educations'));
    }

    public function EducationRecordStore(Request $request)
    {
        $validated = $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'education_id' => 'required', // ปรับตามชื่อ table จริง เช่น exists:educations,id
            'semester'     => 'required|string|max:10',
            'school_name'  => 'required|string',
            'record_date'  => 'required|date',
            'grade_average' => 'nullable|numeric',
            'subjects'     => 'nullable|array',
            'subjects.*.subject_id' => 'sometimes',
            'subjects.*.score'      => 'sometimes',
            'subjects.*.grade'      => 'sometimes',
        ]);

        // กันบันทึกซ้ำ
        $existingRecord = EducationRecord::where('client_id', $validated['client_id'])
            ->where('education_id', $validated['education_id'])
            ->where('semester', $validated['semester'])
            ->first();

        if ($existingRecord) {
            return back()->with('error', 'มีการบันทึกผลการเรียนในภาคเรียนนี้แล้ว')->withInput();
        }

        // Insert record
        $record = EducationRecord::create([
            'client_id'    => $validated['client_id'],
            'education_id' => $validated['education_id'],
            'semester'     => $validated['semester'],
            'school_name'  => $validated['school_name'],
            'record_date'  => $validated['record_date'],
            'grade_average' => $validated['grade_average'] ?? null,
        ]);

        // Attach subjects ถ้ามี
        if (!empty($validated['subjects'])) {
            foreach ($validated['subjects'] as $data) {
                if (!empty($data['subject_id'])) {
                    $record->subjects()->attach($data['subject_id'], [
                        'score' => $data['score'] ?? null,
                        'grade' => $data['grade'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('education_record_show', ['client_id' => $validated['client_id']])
                         ->with('success','บันทึกผลการเรียนเรียบร้อยแล้ว');
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
        $record = EducationRecord::with('subjects')->findOrFail($id);
        $client = $record->client;
        $subjects = Subject::all();
        $educations = Education::all();

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
            'education_id' => 'required', // ปรับตามชื่อ table จริง
            'semester'     => 'required|string',
            'school_name'  => 'required|string',
            'record_date'  => 'required|date',
            'grade_average'=> 'nullable|numeric|regex:/^\d{1,3}(\.\d{1,2})?$/',
            'subjects'     => 'required|array',
            'subjects.*.subject_id' => 'required|exists:subjects,id',
            'subjects.*.score'      => 'required|numeric|min:0|max:100',
            'subjects.*.grade'      => 'required|string',
        ]);

        $subjectIds = array_column($validated['subjects'], 'subject_id');
        if (count($subjectIds) !== count(array_unique($subjectIds))) {
            return back()->with('error', 'ไม่สามารถเลือกวิชาเดิมซ้ำในฟอร์มเดียวกันได้');
        }

        $record = EducationRecord::findOrFail($id);

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

        $syncData = [];
        foreach ($validated['subjects'] as $data) {
            $syncData[$data['subject_id']] = [
                'score' => $data['score'],
                'grade' => $data['grade'],
            ];
        }

        $record->subjects()->sync($syncData);

        return redirect()->route('education_record_show', ['client_id' => $validated['client_id']])
                         ->with('success','แก้ไขผลการเรียนเรียบร้อยแล้ว');
    }

    // ✅ เพิ่ม method สำหรับแสดงผลการเรียน
    public function EducationRecordShow($client_id)
    {
       $client = Client::findOrFail($client_id);

    $educationRecords = EducationRecord::with('subjects','education')
        ->where('client_id', $client_id)
        ->orderBy('record_date', 'desc') // ✅ เรียงจากล่าสุดไปเก่า
        ->get();

    if ($educationRecords->isEmpty()) {
        return redirect()->route('education_record_add', ['client_id' => $client_id])
                         ->with('info', 'ยังไม่มีข้อมูลผลการเรียน กรุณาบันทึกข้อมูลก่อน');
    }

    return view('frontend.client.education_record.education_record_show', compact('client','educationRecords'));

    }
}