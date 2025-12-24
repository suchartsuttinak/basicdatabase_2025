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
  public function AbsentAdd($client_id)
{
    $client = Client::findOrFail($client_id);

    // ตรวจสอบว่ามีข้อมูลการศึกษาเด็กหรือไม่
    $educationRecord = EducationRecord::with('education')
        ->where('client_id', $client_id)
        ->orderByDesc('record_date')
        ->first();

    if (!$educationRecord) {
        // ถ้าไม่มีข้อมูลการศึกษา → redirect ไปหน้าเพิ่มการศึกษาเด็ก
        return redirect()->route('education_record.add', $client_id)
            ->with([
                'message' => 'กรุณาเพิ่มข้อมูลการศึกษาเด็กก่อนบันทึกการขาดเรียน',
                'alert-type' => 'warning'
            ]);
    }

    // ถ้ามีข้อมูลการศึกษาแล้ว → ดึงข้อมูลการขาดเรียน
    $absents = Absent::where('client_id', $client_id)
        ->orderByDesc('absent_date')
        ->get();

    return view('frontend.client.absent.absent_create', [
        'client'          => $client,
        'educationRecord' => $educationRecord,
        'client_id'       => $client_id,
        'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
        'education_name'  => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
        'absents'         => $absents, // ✅ สำหรับ list
        'absent'          => null,     // ✅ สำหรับ form
    ]);
}

    public function AbsentStore(Request $request)
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

        $validated['education_record_id'] = $validated['education_record_id'] ?: null;

        Absent::create($validated);

        return redirect()
            ->route('absent.add', $request->client_id) // ✅ ใช้ชื่อ route ที่ถูกต้อง
            ->with([
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }

    public function AbsentReport($absent_id)
    {
        $absent = Absent::with(['educationRecord.education'])->findOrFail($absent_id);
        $client = Client::findOrFail($absent->client_id);

        $educationRecord = EducationRecord::with('education')
            ->where('client_id', $client->id)
            ->orderByDesc('record_date')
            ->first();

        $age = $client->birth_date
            ? Carbon::parse($client->birth_date)->age
            : 'ไม่พบข้อมูล';

        return view('frontend.client.absent.absent_report', [
            'client'          => $client,
            'educationRecord' => $educationRecord,
            'absent'          => $absent,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
            'term'            => optional($educationRecord)->semester ?? 'ไม่พบข้อมูล',
            'age'             => $age,
        ]);
    }

    public function AbsentEdit($id)
    {
        $absent = Absent::findOrFail($id);
        $client = Client::findOrFail($absent->client_id);

        $educationRecord = EducationRecord::with('education')
            ->where('client_id', $client->id)
            ->orderByDesc('record_date')
            ->first();

        return view('frontend.client.absent.absent_create', [
            'absent'          => $absent, // ✅ record เดี่ยวสำหรับ edit form
            'client'          => $client,
            'educationRecord' => $educationRecord,
            'client_id'       => $client->id,
            'school_name'     => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล',
            'education_name'  => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล',
            'absents'         => Absent::where('client_id', $client->id)
                                    ->orderByDesc('absent_date')
                                    ->get(),
        ]);
    }

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

    public function AbsentDelete($id)
    {
        $absent = Absent::findOrFail($id);
        $clientId = $absent->client_id;
        $absent->delete();

        return redirect()
            ->route('absent.add', $clientId)
            ->with([
                'message' => 'ลบข้อมูลการติดตามเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ]);
    }
}