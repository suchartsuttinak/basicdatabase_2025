<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;   // ✅ import ที่นี่เท่านั้น
use App\Models\Client;
use App\Models\CaseOutside;
use App\Models\Outside;

class CaseOutsideController extends Controller
{
    public function ShowCaseOutside($client_id)
    {
        $outside = Outside::all();
        $client  = Client::findOrFail($client_id);

        $caseoutsides = CaseOutside::where('client_id', $client->id)
            ->orderBy('count', 'desc')
            ->get();

        return view('frontend.client.case_outside.case_outside_create',
            compact('client','client_id','caseoutsides','outside'));
    }

    public function StoreCaseOutside(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                Rule::unique('case_outsides')->where(function ($query) use ($request) {
                    return $query->where('client_id', $request->client_id);
                }),
            ],
            'outside_id' => 'required|exists:outsides,id',
            'follo_no'   => 'required',
            'results'    => 'required|string',
            'teacher'    => 'nullable|string',
            'remerk'     => 'nullable|string',
            'dormitory'  => 'required|string',
            'client_id'  => 'required|exists:clients,id',
        ], [
            'date.required'     => 'กรุณากรอกวันที่',
            'date.date'         => 'รูปแบบวันที่ไม่ถูกต้อง',
            'date.unique'       => 'วันที่ติดตามนี้มีอยู่แล้ว ห้ามซ้ำ',
            'outside_id.required' => 'กรุณาเลือกข้อมูลภายนอก',
            'outside_id.exists'   => 'ข้อมูลภายนอกไม่ถูกต้อง',
            'follo_no.required'   => 'กรุณากรอกเลขที่ติดตาม',
            'results.string'      => 'ผลการติดตามต้องเป็นข้อความ',
            'results.required'    => 'กรุณากรอกผลการติดตาม',
            'teacher.string'      => 'ชื่อครูต้องเป็นข้อความ',
            'remerk.string'       => 'หมายเหตุต้องเป็นข้อความ',
            'dormitory.required'  => 'กรุณากรอกหอพัก',
            'dormitory.string'    => 'หอพักต้องเป็นข้อความ',
            'client_id.required'  => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists'    => 'ผู้รับบริการไม่ถูกต้อง',
        ]);

        DB::transaction(function () use ($validated) {
            $case = CaseOutside::create($validated);
            $this->reindexCounts($case->client_id);
        });

        return redirect()->route('case_outside.show', $request->client_id)
            ->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function UpdateCaseOutside(Request $request, $id)
    {
        $case = CaseOutside::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date' => [
                'required',
                'date',
                Rule::unique('case_outsides', 'date')
                    ->where(fn($query) => $query->where('client_id', $case->client_id))
                    ->ignore($case->id),
            ],
            'outside_id' => 'required|exists:outsides,id',
            'follo_no'   => 'required',
            'results'    => 'required|string',
            'teacher'    => 'nullable|string',
            'remerk'     => 'nullable|string',
            'dormitory'  => 'required|string',
            'client_id'  => 'required|exists:clients,id',
        ], [
            'date.required'       => 'กรุณากรอกวันที่',
            'date.date'           => 'รูปแบบวันที่ไม่ถูกต้อง',
            'date.unique'         => 'วันที่ติดตามนี้มีอยู่แล้ว ห้ามซ้ำ',
            'outside_id.required' => 'กรุณาเลือกข้อมูลภายนอก',
            'outside_id.exists'   => 'ข้อมูลภายนอกไม่ถูกต้อง',
            'follo_no.required'   => 'กรุณาเลือกการดำเนินงาน',
            'results.string'      => 'ผลการติดตามต้องเป็นข้อความ',
            'results.required'    => 'ผลการติดตามต้องไม่เป็นค่าว่าง',
            'teacher.string'      => 'ชื่อครูต้องเป็นข้อความ',
            'remerk.string'       => 'หมายเหตุต้องเป็นข้อความ',
            'dormitory.required'  => 'สถานที่พักต้องมีข้อมูล',
            'dormitory.string'    => 'สถานที่พักต้องมีข้อมูล',
            'client_id.required'  => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists'    => 'ผู้รับบริการไม่ถูกต้อง',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all() + ['case_id' => $id]);
        }

        DB::transaction(function () use ($case, $validator) {
            $case->update($validator->validated());
            $this->reindexCounts($case->client_id);
        });

        return redirect()
            ->route('case_outside.show', $case->client_id)
            ->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

     public function DeleteCaseOutside($id)
    {
        $case = CaseOutside::findOrFail($id);
        $client_id = $case->client_id;

        DB::transaction(function () use ($case) {
            $client_id = $case->client_id;
            $case->delete();

            // ✅ ลบแล้ว reindex ใหม่ทั้งหมดตามวัน (asc)
            $this->reindexCounts($client_id);
        });

        return redirect()->route('case_outside.show', $client_id)
            ->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    /**
     * Reindex count ตามวันที่ (asc) ให้ต่อเนื่อง 1..n
     */
    private function reindexCounts($client_id)
    {
        $items = CaseOutside::where('client_id', $client_id)
            ->orderBy('date', 'asc')
            ->get();

        $counter = 1;
        foreach ($items as $item) {
            // อัปเดตเฉพาะ count เพื่อความเร็ว
            $item->update(['count' => $counter]);
            $counter++;
        }
    }
}
