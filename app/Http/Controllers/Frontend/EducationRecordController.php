<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Client;
use App\Models\Subject;
use App\Models\Education;
use App\Models\Institution;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\EducationRecord;
use App\Http\Controllers\Controller;

class EducationRecordController extends Controller
{
    public function EducationRecordAdd($client_id)
{
    $client = Client::findOrFail($client_id);
    $subjects = Subject::all();

    // ✅ เรียง semester_name ตามปีและเทอมจริง ๆ  
        $semesters = Semester::orderByRaw("
        CAST(SUBSTRING_INDEX(semester_name, '/', -1) AS UNSIGNED) DESC,
        CAST(SUBSTRING_INDEX(semester_name, '/', 1) AS UNSIGNED) DESC
    ")->get();

    $educations = Education::all();

    return view('frontend.client.education_record.education_record_create',
        compact('client','subjects', 'semesters', 'educations'));
}

    public function EducationRecordStore(Request $request)
    {
        $validated = $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'education_id' => 'required',
            'semester_id'  => 'required|exists:semesters,id', // ✅ ใช้ FK
            'school_name'  => 'required|string',
            'record_date'  => 'required|date',
            'grade_average'=> 'nullable|numeric',
            'subjects'     => 'nullable|array',
            'subjects.*.subject_id' => 'nullable|exists:subjects,id',
            'subjects.*.score'      => 'nullable|numeric|min:0|max:100',
            'subjects.*.grade'      => 'nullable|string',
        ], [
            'semester_id.required' => 'กรุณาเลือกภาคเรียน',
            'semester_id.exists'   => 'ภาคเรียนที่เลือกไม่ถูกต้อง',
        ]);

        // ✅ กันบันทึกซ้ำ
        $existingRecord = EducationRecord::where('client_id', $validated['client_id'])
            ->where('education_id', $validated['education_id'])
            ->where('semester_id', $validated['semester_id'])
            ->first();

        if ($existingRecord) {
            return back()->with('error', 'มีการบันทึกผลการเรียนในภาคเรียนนี้แล้ว')->withInput();
        }

        $institution = Institution::firstOrCreate([
            'institution_name' => $validated['school_name']
        ]);

        // ✅ กันเลือกวิชาซ้ำ
        if (!empty($validated['subjects'])) {
            $subjectIds = array_column($validated['subjects'], 'subject_id');
            if (count($subjectIds) !== count(array_unique($subjectIds))) {
                return back()->with('error', 'ไม่สามารถเลือกวิชาเดิมซ้ำในฟอร์มเดียวกันได้')->withInput();
            }
        }

        $record = EducationRecord::create([
            'client_id'     => $validated['client_id'],
            'education_id'  => $validated['education_id'],
            'semester_id'   => $validated['semester_id'], // ✅ เก็บ FK
            'school_name'   => $validated['school_name'],
            'institution_id'=> $institution->id,
            'record_date'   => $validated['record_date'],
            'grade_average' => $validated['grade_average'] ?? null,
        ]);

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

   public function EducationRecordEdit($id)
{
    $record = EducationRecord::with('subjects')->findOrFail($id);
    $client = $record->client;
    $subjects = Subject::all();
    $educations = Education::all();

    // ✅ เรียง semester_name ตามปีและเทอมจริง ๆ
    $semesters = Semester::orderByRaw("
        CAST(SUBSTRING_INDEX(semester_name, '/', -1) AS UNSIGNED) DESC,
        CAST(SUBSTRING_INDEX(semester_name, '/', 1) AS UNSIGNED) DESC
    ")->get();

    return view('frontend.client.education_record.education_record_edit',
        compact('record','client','subjects','educations','semesters'));
}

    public function EducationRecordUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'education_id' => 'required',
            'semester_id'  => 'required|exists:semesters,id', // ✅ ใช้ FK
            'school_name'  => 'required|string',
            'record_date'  => 'required|date',
            'grade_average'=> 'nullable|numeric|regex:/^\d{1,3}(\.\d{1,2})?$/',
            'subjects'     => 'nullable|array',
            'subjects.*.subject_id' => 'nullable|exists:subjects,id',
            'subjects.*.score'      => 'nullable|numeric|min:0|max:100',
            'subjects.*.grade'      => 'nullable|string',
        ]);

        $record = EducationRecord::findOrFail($id);

        if (!empty($validated['subjects'])) {
            $subjectIds = array_column($validated['subjects'], 'subject_id');
            if (count($subjectIds) !== count(array_unique($subjectIds))) {
                return back()->with('error', 'ไม่สามารถเลือกวิชาเดิมซ้ำในฟอร์มเดียวกันได้')->withInput();
            }
        }

        $record->update([
            'client_id'    => $validated['client_id'],
            'education_id' => $validated['education_id'],
            'semester_id'  => $validated['semester_id'], // ✅ เก็บ FK
            'school_name'  => $validated['school_name'],
            'record_date'  => $validated['record_date'],
            'grade_average'=> $validated['grade_average'] !== null 
                ? number_format($validated['grade_average'], 2, '.', '') 
                : null,
        ]);

        $syncData = [];
        if (!empty($validated['subjects'])) {
            foreach ($validated['subjects'] as $data) {
                if (!empty($data['subject_id'])) {
                    $syncData[$data['subject_id']] = [
                        'score' => $data['score'] ?? null,
                        'grade' => $data['grade'] ?? null,
                    ];
                }
            }
        }

        $record->subjects()->sync($syncData);

        return redirect()->route('education_record_show', ['client_id' => $validated['client_id']])
                         ->with('success','แก้ไขผลการเรียนเรียบร้อยแล้ว');
    }

    public function EducationRecordShow($client_id)
    {
        $client = Client::findOrFail($client_id);

        $educationRecords = EducationRecord::with('subjects','education','semester') // ✅ ดึง semester FK
            ->where('client_id', $client_id)
            ->orderBy('record_date', 'desc')
            ->get();

        if ($educationRecords->isEmpty()) {
            return redirect()->route('education_record_add', ['client_id' => $client_id])
                             ->with('info', 'ยังไม่มีข้อมูลผลการเรียน กรุณาบันทึกข้อมูลก่อน');
        }

        return view('frontend.client.education_record.education_record_show',
            compact('client','educationRecords'));
    }

     // 📌 ลบผลการเรียน
    public function EducationRecordDelete($id)
    {
        $record = EducationRecord::findOrFail($id);
        $client_id = $record->client_id;

        // ลบความสัมพันธ์กับ subjects ก่อน
        $record->subjects()->detach();

        $record->delete();

        return redirect()->route('education_record_show', ['client_id' => $client_id])
                         ->with('success', 'ลบข้อมูลผลการเรียนเรียบร้อยแล้ว');
    }


}