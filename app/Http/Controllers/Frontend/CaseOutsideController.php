<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\CaseOutside;
use App\Models\Outside;

class CaseOutsideController extends Controller
{
    public function ShowCaseOutside($client_id)
    {
        $outside = Outside::all();
        $client  = Client::findOrFail($client_id);

        // แสดงผลเรียงตาม count จากมากไปน้อย (ตาม requirement หน้าแสดงผล)
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
            'results'    => 'nullable|string',
            'teacher'    => 'nullable|string',
            'remerk'     => 'nullable|string',
            'dormitory'  => 'nullable|string',
            'client_id'  => 'required|exists:clients,id',
        ], [
            'date.unique' => 'วันที่ติดตามนี้มีอยู่แล้ว ห้ามซ้ำ',
        ]);

        DB::transaction(function () use ($validated) {
            // สร้าง record ใหม่ (ยังไม่กำหนด count ที่นี่)
            $case = CaseOutside::create($validated);

            // ✅ reindex count ใหม่ทั้งหมดตามวัน (asc) ของ client เดียวกัน
            $this->reindexCounts($case->client_id);
        });

        return redirect()->route('case_outside.show', $request->client_id)
            ->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function UpdateCaseOutside(Request $request, $id)
    {
        $case = CaseOutside::findOrFail($id);

        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                Rule::unique('case_outsides')->where(function ($query) use ($case, $request) {
                    return $query->where('client_id', $case->client_id);
                })->ignore($case->id),
            ],
            'outside_id' => 'required|exists:outsides,id',
            'follo_no'   => 'required',
            'results'    => 'nullable|string',
            'teacher'    => 'nullable|string',
            'remerk'     => 'nullable|string',
            'dormitory'  => 'nullable|string',
        ], [
            'date.unique' => 'วันที่ติดตามนี้มีอยู่แล้ว ห้ามซ้ำ',
        ]);

        DB::transaction(function () use ($case, $validated) {
            // อัปเดตข้อมูล
            $case->update($validated);

            // ✅ reindex count ใหม่ทั้งหมดตามวัน (asc) ของ client เดียวกัน
            $this->reindexCounts($case->client_id);
        });

        return redirect()->route('case_outside.show', $case->client_id)
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



