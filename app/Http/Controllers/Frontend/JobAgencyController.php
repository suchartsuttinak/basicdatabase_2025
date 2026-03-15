<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\JobAgency;
use App\Models\Occupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class JobAgencyController extends Controller
{
    /**
     * แสดงรายการ JobAgency ของ client
     */
    /**
     * แสดงข้อมูล JobAgency ของ client
     */
    public function showJobAgency($client_id)
{
    $client = Client::findOrFail($client_id);

    $jobAgencies = JobAgency::where('client_id', $client->id)
        ->orderBy('income', 'desc')
        ->with('occupation') // ✅ eager load occupation
        ->get();

    $occupations = Occupation::all();

    return view('frontend.client.job_agency.job_agency', compact(
        'client',
        'client_id',
        'jobAgencies',
        'occupations'
    ));
}

public function storeJobAgency(Request $request)
{
    $validated = $request->validate([
    'job_date' => [
        'required',
        'date',
        Rule::unique('job_agencies')->where(fn($q) => 
            $q->where('client_id', $request->client_id)
        ),
    ],
        'occupation_id' => 'required|exists:occupations,id',
        'position'      => 'required|string',
        'income'        => 'required|numeric',
        'company'       => 'required|string',
        'coordinator'   => 'required|string',
        'remark'        => 'nullable|string',
        'client_id'     => 'required|exists:clients,id',
    ], [
        'job_date.required'     => 'กรุณากรอกวันที่เริ่มงาน',
        'job_date.date'         => 'รูปแบบวันที่ไม่ถูกต้อง',
        'job_date.unique'       => 'วันที่เริ่มงานนี้มีอยู่แล้ว ห้ามซ้ำ',

        'occupation_id.required'=> 'กรุณาเลือกอาชีพ',
        'occupation_id.exists'  => 'อาชีพที่เลือกไม่ถูกต้อง',

        'position.required'     => 'กรุณากรอกตำแหน่งงาน',
        'position.string'       => 'ตำแหน่งงานต้องเป็นข้อความ',

        'income.required'       => 'กรุณากรอกรายได้',
        'income.numeric'        => 'รายได้ต้องเป็นตัวเลข',

        'company.required'      => 'กรุณากรอกชื่อบริษัท',
        'company.string'        => 'ชื่อบริษัทต้องเป็นข้อความ',

        'coordinator.required'  => 'กรุณากรอกชื่อผู้ประสานงาน',
        'coordinator.string'    => 'ชื่อผู้ประสานงานต้องเป็นข้อความ',

        'remark.string'         => 'หมายเหตุต้องเป็นข้อความ',

        'client_id.required'    => 'กรุณาเลือกผู้รับบริการ',
        'client_id.exists'      => 'ผู้รับบริการที่เลือกไม่ถูกต้อง',
    ]);

    $jobAgency = DB::transaction(fn() => JobAgency::create($validated));

    // ✅ ใช้ client_id เพราะ route รับ client_id
    return redirect()->route('job_agencies.show', $jobAgency->client_id)
        ->with('success', 'บันทึกข้อมูลเรียบร้อย');
}
    /**
     * อัปเดตข้อมูล
     */
    public function updateJobAgency(Request $request, $id)
{
    $jobAgency = JobAgency::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'job_date' => [
            'required',
            'date',
            Rule::unique('job_agencies')
                ->where(fn($query) => $query->where('client_id', $jobAgency->client_id))
                ->ignore($jobAgency->id),
        ],
        'occupation_id' => 'required|exists:occupations,id',
        'position'      => 'required|string',
        'income'        => 'required|numeric',
        'company'       => 'required|string',
        'coordinator'   => 'required|string',
        'remark'        => 'nullable|string',
    ], [
        // … ข้อความ error ภาษาไทย …
    ]);

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput($request->all() + ['job_id' => $id]); // ✅ ส่ง job_id กลับไป
    }

    DB::transaction(function () use ($jobAgency, $validator) {
        $jobAgency->update($validator->validated());
    });

    return redirect()
        ->route('job_agencies.show', $jobAgency->client_id)
        ->with('success', 'แก้ไขข้อมูลเรียบร้อย');
}

    /**
     * ลบข้อมูล
     */
   public function deleteJobAgency($id)
{
    $jobAgency = JobAgency::findOrFail($id);
    $client_id = $jobAgency->client_id;

    DB::transaction(function () use ($jobAgency) {
        $jobAgency->delete();
    });

 return redirect()->route('job_agencies.show', $client_id)
    ->with('success', 'ลบข้อมูลเรียบร้อย');
}
 
}

