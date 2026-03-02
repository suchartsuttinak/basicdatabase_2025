<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\JobAgency;
use App\Models\Occupation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            Rule::unique('job_agencies')->where(fn($q) => $q->where('client_id', $request->client_id)),
        ],
        'occupation_id' => 'required|exists:occupations,id',
        'position'      => 'required|string',
        'income'        => 'required|numeric',
        'company'       => 'required|string',
        'coordinator'   => 'required|string',
        'remark'        => 'nullable|string',
        'client_id'     => 'required|exists:clients,id',
    ], [
        'job_date.unique' => 'วันที่เริ่มงานนี้มีอยู่แล้ว ห้ามซ้ำ',
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

        $validated = $request->validate([
            'job_date' => [
                'required',
                'date',
                Rule::unique('job_agencies')->where(function ($query) use ($jobAgency) {
                    return $query->where('client_id', $jobAgency->client_id);
                })->ignore($jobAgency->id),
            ],
            'occupation_id' => 'required|exists:occupations,id',
            'position'      => 'required|string',
            'income'        => 'required|numeric',
            'company'       => 'required|string',
            'coordinator'   => 'required|string',
            'remark'        => 'nullable|string',
        ], [
            'job_date.unique' => 'วันที่เริ่มงานนี้มีอยู่แล้ว ห้ามซ้ำ',
        ]);

        DB::transaction(function () use ($jobAgency, $validated) {
            $jobAgency->update($validated);
        });

       return redirect()->route('job_agencies.show', $jobAgency->client_id)
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

