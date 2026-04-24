<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Client;
use App\Models\Estimate;
use App\Models\EstimatePicture;
use Illuminate\Support\Facades\Validator;

class EstimateController extends Controller
{
    public function IndexEstimate($client_id)
    {
        $client = Client::forUser(auth()->user()) // ✅ [แก้ไข]
            ->with('estimates.pictures')
            ->findOrFail($client_id);

        return view('frontend.client.estimate.estimate_index', compact('client'));
    }

    public function ShowEstimate($client_id)
    {
        $client = Client::forUser(auth()->user()) // ✅ [แก้ไข]
            ->with('estimates.pictures')
            ->findOrFail($client_id);

        return view('frontend.client.estimate.estimate_index', compact('client'));
    }

    public function AddEstimate($id)
    {
        $estimate = Estimate::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->with('pictures')
            ->firstOrFail(); // ✅ [แก้ไข]

        return response()->json($estimate);
    }

    public function StoreEstimate(Request $request)
    {
        // ✅ [แก้ไข] กัน POST ยิง client คนอื่น
        $client = Client::forUser(auth()->user())
            ->where('id', $request->client_id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'date' => [
                'required',
                'date',
                Rule::unique('estimates')->where(function ($query) use ($request) {
                    return $query->where('client_id', $request->client_id);
                }),
            ],
            'follo_no' => 'required',
            'results'  => 'nullable|string',
            'family_income' => 'nullable|numeric|min:0',
            'guardian_job' => 'nullable|string|max:255',
            'income_sufficiency' => 'required|in:เพียงพอ,ไม่เพียงพอ',
            'income_reason' => 'nullable|string',
            'debt' => 'nullable|string',
            'housing_condition' => 'nullable|in:ดี,พอใช้,ควรปรับปรุง',
            'teacher'  => 'nullable|string|max:255',
            'remark'   => 'nullable|string',
            'client_id'=> 'required|exists:clients,id',
        ], [
            'date.unique' => 'วันที่นี้ถูกบันทึกไว้แล้ว กรุณาเลือกวันอื่น',
            'date.required' => 'กรุณาเลือกวันที่',
            'date.date' => 'รูปแบบวันที่ไม่ถูกต้อง',
            'follo_no.required' => 'กรุณาเลือกการดำเนินงาน',
            'income_sufficiency.required' => 'กรุณาเลือกความเพียงพอของรายได้',
            'income_sufficiency.in' => 'ค่าความเพียงพอของรายได้ไม่ถูกต้อง',
            'housing_condition.in' => 'ค่าสภาพที่อยู่อาศัยไม่ถูกต้อง',
            'family_income.numeric' => 'รายได้ครอบครัวเฉลี่ย/เดือนต้องเป็นตัวเลข',
            'family_income.min' => 'รายได้ครอบครัวเฉลี่ย/เดือนต้องไม่น้อยกว่า 0',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'add-estimate');
        }

        $data = $validator->validated();
        $data['client_id'] = $client->id; // ✅ [แก้ไข]

        // ✅ ถ้าเลือกเพียงพอ ไม่ต้องเก็บเหตุผล
        if (($data['income_sufficiency'] ?? 'เพียงพอ') === 'เพียงพอ') {
            $data['income_reason'] = null;
        }

        $estimate = Estimate::create($data);

        // ✅ นับครั้งอัตโนมัติใหม่ทั้งหมด เรียงตามวัน
        $estimates = Estimate::where('client_id', $estimate->client_id)
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $counter = 1;
        foreach ($estimates as $item) {
            $item->update(['count' => $counter]);
            $counter++;
        }

        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $file) {
                $path = $file->store('estimate_pictures', 'public');
                $estimate->pictures()->create(['path' => $path]);
            }
        }

        return redirect()->route('estimate.show', $estimate->client_id)
            ->with([
                'message'    => 'บันทึกข้อมูลเรียบร้อย',
                'alert-type' => 'success'
            ]);
    }

    public function EditEstimate($id)
    {
        $estimate = Estimate::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->with('pictures')
            ->firstOrFail(); // ✅ [แก้ไข]

        return response()->json([
            'id' => $estimate->id,
            'client_id' => $estimate->client_id,
            'date' => \Carbon\Carbon::parse($estimate->date)->format('Y-m-d'),
            'follo_no' => $estimate->follo_no,
            'results' => $estimate->results,
            'family_income' => $estimate->family_income,
            'guardian_job' => $estimate->guardian_job,
            'income_sufficiency' => $estimate->income_sufficiency ?? 'เพียงพอ',
            'income_reason' => $estimate->income_reason,
            'debt' => $estimate->debt,
            'housing_condition' => $estimate->housing_condition,
            'teacher' => $estimate->teacher,
            'remark' => $estimate->remark,
            'pictures' => $estimate->pictures->map(fn($pic) => [
                'id'  => $pic->id,
                'url' => asset('storage/' . $pic->path),
            ]),
        ]);
    }

    public function UpdateEstimate(Request $request, $id)
    {
        $estimate = Estimate::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->firstOrFail(); // ✅ [แก้ไข]

        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                Rule::unique('estimates')
                    ->where(fn($q) => $q->where('client_id', $estimate->client_id))
                    ->ignore($estimate->id),
            ],
            'follo_no' => 'required',
            'results' => 'nullable|string',
            'family_income' => 'nullable|numeric|min:0',
            'guardian_job' => 'nullable|string|max:255',
            'income_sufficiency' => 'required|in:เพียงพอ,ไม่เพียงพอ',
            'income_reason' => 'nullable|string',
            'debt' => 'nullable|string',
            'housing_condition' => 'nullable|in:ดี,พอใช้,ควรปรับปรุง',
            'teacher' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
        ], [
            'date.unique' => 'วันที่นี้ถูกบันทึกไว้แล้ว กรุณาเลือกวันอื่น',
            'date.required' => 'กรุณาเลือกวันที่',
            'date.date' => 'รูปแบบวันที่ไม่ถูกต้อง',
            'follo_no.required' => 'กรุณาเลือกการดำเนินงาน',
            'income_sufficiency.required' => 'กรุณาเลือกความเพียงพอของรายได้',
            'income_sufficiency.in' => 'ค่าความเพียงพอของรายได้ไม่ถูกต้อง',
            'housing_condition.in' => 'ค่าสภาพที่อยู่อาศัยไม่ถูกต้อง',
            'family_income.numeric' => 'รายได้ครอบครัวเฉลี่ย/เดือนต้องเป็นตัวเลข',
            'family_income.min' => 'รายได้ครอบครัวเฉลี่ย/เดือนต้องไม่น้อยกว่า 0',
        ]);

        // ✅ ถ้าเลือกเพียงพอ ไม่ต้องเก็บเหตุผล
        if (($validated['income_sufficiency'] ?? 'เพียงพอ') === 'เพียงพอ') {
            $validated['income_reason'] = null;
        }

        $estimate->update($validated);

        if ($request->has('remove_pictures')) {
            foreach ($request->remove_pictures as $picId) {
                $pic = EstimatePicture::find($picId);
                if ($pic) {
                    \Storage::disk('public')->delete($pic->path);
                    $pic->delete();
                }
            }
        }

        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $file) {
                $path = $file->store('estimate_pictures', 'public');
                $estimate->pictures()->create(['path' => $path]);
            }
        }

        // ✅ นับครั้งอัตโนมัติใหม่ทั้งหมด เรียงตามวัน
        $estimates = Estimate::where('client_id', $estimate->client_id)
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $counter = 1;
        foreach ($estimates as $item) {
            $item->update(['count' => $counter]);
            $counter++;
        }

        return redirect()->route('estimate.show', $estimate->client_id)
            ->with([
                'message' => 'แก้ไขข้อมูลเรียบร้อย',
                'alert-type' => 'success'
            ]);
    }

    public function DeleteEstimate($id)
    {
        $estimate = Estimate::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->firstOrFail(); // ✅ [แก้ไข]

        $client_id = $estimate->client_id;
        $estimate->delete();

        // ✅ นับครั้งอัตโนมัติใหม่ทั้งหมด เรียงตามวัน
        $estimates = Estimate::where('client_id', $client_id)
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $counter = 1;
        foreach ($estimates as $item) {
            $item->update(['count' => $counter]);
            $counter++;
        }

        return redirect()->route('estimate.show', $client_id)
            ->with([
                'message' => 'ลบข้อมูลเรียบร้อย',
                'alert-type' => 'success'
            ]);
    }

    public function CheckDuplicate(Request $request)
    {
        // ✅ [แก้ไข] ตรวจสิทธิ์ client ก่อน
        $client = Client::forUser(auth()->user())
            ->where('id', $request->client_id)
            ->firstOrFail();

        $exists = Estimate::where('client_id', $client->id) // ✅ [แก้ไข]
            ->where('date', $request->date)
            ->where('id', '!=', $request->id)
            ->exists();

        return response()->json(['duplicate' => $exists]);
    }

    // ✅ เพิ่มหน้ารายงานรายรายการ
    public function ReportEstimate($id)
    {
        $estimate = Estimate::where('id', $id)
            ->whereHas('client', function ($q) {
                $q->forUser(auth()->user());
            })
            ->with(['client', 'pictures'])
            ->firstOrFail();

        return view('frontend.client.estimate.estimate_report', compact('estimate'));
    }
}