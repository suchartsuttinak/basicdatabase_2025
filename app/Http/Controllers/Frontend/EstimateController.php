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
    // แสดงรายการทั้งหมดของ client
    public function IndexEstimate($client_id)
    {
        $client = Client::with('estimates.pictures')->findOrFail($client_id);
        return view('frontend.client.estimate.estimate_index', compact('client'));
    }

    public function ShowEstimate($client_id)
    {
        $client = Client::with('estimates.pictures')->findOrFail($client_id);
        return view('frontend.client.estimate.estimate_index', compact('client'));
    }

    // ฟอร์มเพิ่มข้อมูล
    public function AddEstimate($id)
    {
        $estimate = Estimate::with('pictures')->findOrFail($id);
        return response()->json($estimate);
    }

    // บันทึกข้อมูลใหม่
    public function StoreEstimate(Request $request)
{
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
        'teacher'  => 'nullable|string',
        'remark'   => 'nullable|string',
        'client_id'=> 'required|exists:clients,id',
    ], [
        'date.unique'       => 'วันที่นี้ถูกบันทึกไว้แล้ว กรุณาเลือกวันอื่น',
        'date.required'     => 'กรุณาเลือกวันที่',
        'date.date'         => 'รูปแบบวันที่ไม่ถูกต้อง',
        'follo_no.required' => 'กรุณาเลือกการดำเนินงาน',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput()
            ->with('form', 'add-estimate'); // ✅ บอกว่า error มาจาก Add
    }

    $estimate = Estimate::create($validator->validated());

    // reindex count ใหม่ทั้งหมด
    $estimates = Estimate::where('client_id', $estimate->client_id)
        ->orderBy('date', 'asc')
        ->get();
    $counter = 1;
    foreach ($estimates as $item) {
        $item->update(['count' => $counter]);
        $counter++;
    }

    // อัพโหลดรูป
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


    // ฟอร์มแก้ไข
    public function EditEstimate($id)
    {
        $estimate = Estimate::with('pictures')->findOrFail($id);
        return response()->json([
            'id'       => $estimate->id,
            'date'     => \Carbon\Carbon::parse($estimate->date)->format('Y-m-d'),
            'follo_no' => $estimate->follo_no,
            'results'  => $estimate->results,
            'teacher'  => $estimate->teacher,
            'remark'   => $estimate->remark,
            'pictures' => $estimate->pictures->map(fn($pic) => [
                'id'  => $pic->id,
                'url' => asset('storage/'.$pic->path),
            ]),
        ]);
    }

    // อัพเดตข้อมูล
    public function UpdateEstimate(Request $request, $id)
    {
        $estimate = Estimate::findOrFail($id);

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
            'teacher' => 'nullable|string',
            'remark' => 'nullable|string',
        ], [
            'date.unique' => 'วันที่นี้ถูกบันทึกไว้แล้ว กรุณาเลือกวันอื่น',
            'date.required' => 'กรุณาเลือกวันที่',
            'date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
            'follo_no.required' => 'กรุณาเลือกการดำเนินงาน',
        ]);

        $estimate->update($validated);

        // ลบรูปเดิม
        if ($request->has('remove_pictures')) {
            foreach ($request->remove_pictures as $picId) {
                $pic = EstimatePicture::find($picId);
                if ($pic) {
                    \Storage::disk('public')->delete($pic->path);
                    $pic->delete();
                }
            }
        }

        // อัพโหลดรูปใหม่
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $file) {
                $path = $file->store('estimate_pictures', 'public');
                $estimate->pictures()->create(['path' => $path]);
            }
        }

        // reindex count
        $estimates = Estimate::where('client_id', $estimate->client_id)
            ->orderBy('date', 'asc')
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

    // ลบข้อมูล
    public function DeleteEstimate($id)
    {
        $estimate = Estimate::findOrFail($id);
        $client_id = $estimate->client_id;
        $estimate->delete();

        // reindex count ใหม่
        $estimates = Estimate::where('client_id', $client_id)
            ->orderBy('date', 'asc')
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

    // ตรวจสอบวันที่ซ้ำ (AJAX)
    public function CheckDuplicate(Request $request)
    {
        $exists = Estimate::where('client_id', $request->client_id)
            ->where('date', $request->date)
            ->where('id', '!=', $request->id)
            ->exists();

        return response()->json(['duplicate' => $exists]);
    }
}