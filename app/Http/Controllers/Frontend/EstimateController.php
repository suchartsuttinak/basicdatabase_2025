<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;   // ✅ import ที่ถูกต้อง
use App\Models\Client;
use App\Models\Estimate;
use App\Models\EstimatePicture;

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

    // ฟอร์มเพิ่มข้อมูล (แก้ parameter ให้ถูกต้อง)
    public function AddEstimate($id)
    {
        $estimate = Estimate::with('pictures')->findOrFail($id);
        return response()->json($estimate);
    }

    // บันทึกข้อมูลใหม่
    public function StoreEstimate(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                Rule::unique('estimates')->where(function ($query) use ($request) {
                    return $query->where('client_id', $request->client_id);
                }),
            ],
            'follo_no' => 'required',
            'results' => 'nullable|string',
            'teacher' => 'nullable|string',
            'remark' => 'nullable|string',
            'client_id' => 'required|exists:clients,id',
        ], [
            'date.unique' => 'วันที่นี้ถูกบันทึกไว้แล้ว กรุณาเลือกวันอื่น', // ✅ custom message
        ]);

        // สร้าง record ใหม่
        $estimate = Estimate::create($validated);

        // ✅ reindex count ใหม่ทั้งหมดตามวัน
        $estimates = Estimate::where('client_id', $request->client_id)
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

        $notification = [
            'message' => 'บันทึกข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];


        return redirect()
            ->route('estimate.show', $request->client_id)
            ->with($notification);
    }

    // ฟอร์มแก้ไข
    public function EditEstimate($id)
    {
        $estimate = Estimate::with('pictures')->findOrFail($id);
        $estimate->date = \Carbon\Carbon::parse($estimate->date)->format('Y-m-d');
        return response()->json($estimate);
    }

    // อัพเดตข้อมูล
    public function UpdateEstimate(Request $request, $id)
    {
        $estimate = Estimate::findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'follo_no' => 'required',
            'results' => 'nullable|string',
            'teacher' => 'nullable|string',
            'remark' => 'nullable|string',
        ]);

        $estimate->update($validated);

        // ✅ ลบรูปเดิมที่เลือก
        if ($request->has('remove_pictures')) {
            foreach ($request->remove_pictures as $picId) {
                $pic = EstimatePicture::find($picId);
                if ($pic) {
                    \Storage::disk('public')->delete($pic->path);
                    $pic->delete();
                }
            }
        }

        // ✅ อัพโหลดรูปใหม่
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $file) {
                $path = $file->store('estimate_pictures', 'public');
                $estimate->pictures()->create(['path' => $path]);
            }
        }

        // ✅ reindex count ใหม่หลังแก้ไข
        $estimates = Estimate::where('client_id', $estimate->client_id)
            ->orderBy('date', 'asc')
            ->get();

        $counter = 1;
        foreach ($estimates as $item) {
            $item->update(['count' => $counter]);
            $counter++;
        }

        $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];


        return redirect()->route('estimate.show', $estimate->client_id)
            ->with($notification);
    }

    // ลบข้อมูล
    public function DeleteEstimate($id)
    {
        $estimate = Estimate::findOrFail($id);
        $client_id = $estimate->client_id;
        $estimate->delete();

        // ✅ reindex count ใหม่หลังลบ
        $estimates = Estimate::where('client_id', $client_id)
            ->orderBy('date', 'asc')
            ->get();

        $counter = 1;
        foreach ($estimates as $item) {
            $item->update(['count' => $counter]);
            $counter++;
        }

          $notification = [
            'message' => 'ลบข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

        return redirect()->route('estimate.show', $client_id)
            ->with($notification);
    }
}