<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Subject;
use App\Models\Education;
use App\Models\EducationRecord; // ✅ ต้อง import

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
        'subjects'     => 'required|array',
        'subjects.*.subject_id' => 'required|exists:subjects,id',
        'subjects.*.score'      => 'required|integer|min:0|max:100',
        'subjects.*.grade'      => 'required|string',
    ]);

    // กันไม่ให้เลือก subject_id ซ้ำในฟอร์มเดียวกัน
    $subjectIds = array_column($validated['subjects'], 'subject_id');
    if (count($subjectIds) !== count(array_unique($subjectIds))) {
        return back()->with('error', 'ไม่สามารถเลือกวิชาเดิมซ้ำในฟอร์มเดียวกันได้');
    }

    // ตรวจสอบว่ามี record ภาคเรียนนี้ของนักเรียนคนนี้อยู่แล้วหรือไม่
    $existingRecord = EducationRecord::where('client_id', $validated['client_id'])
        ->where('education_id', $validated['education_id'])
        ->where('semester', $validated['semester'])
        ->first();

    if ($existingRecord) {
        return back()->with('error', 'มีการบันทึกผลการเรียนในภาคเรียนนี้แล้ว');
    }

    // สร้าง EducationRecord ใหม่
    $record = EducationRecord::create([
        'client_id'    => $validated['client_id'],
        'education_id' => $validated['education_id'],
        'semester'     => $validated['semester'],
        'school_name'  => $validated['school_name'],
        'record_date'  => $validated['record_date'],
    ]);

    // แนบผลการเรียน
    foreach ($validated['subjects'] as $data) {
        $record->subjects()->attach($data['subject_id'], [
            'score' => $data['score'],
            'grade' => $data['grade'],
        ]);
    }

    return redirect()->route('education_record.add', ['client_id' => $validated['client_id']])
                     ->with('success','บันทึกผลการเรียนเรียบร้อยแล้ว');
}
}