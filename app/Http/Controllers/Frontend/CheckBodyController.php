<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\CheckBody;

class CheckBodyController extends Controller
{
    // 🟢 แสดงฟอร์มเพิ่มข้อมูล
    public function CheckBodyAdd($client_id)
    {
        $client = Client::findOrFail($client_id);
        $checkbodies = CheckBody::where('client_id', $client->id)
            ->orderBy('assessor_date', 'desc') // เรียงวันที่ล่าสุดก่อน
            ->get();

        $checkbody = null; // สำหรับเพิ่มใหม่

        return view('frontend.client.CheckBody.check_body_add', compact('client', 'client_id', 'checkbodies', 'checkbody'));
    }

    // 🟢 บันทึกข้อมูลใหม่
    public function CheckBodyStore(Request $request)
    {
                $validated = $request->validate([
            'client_id'     => ['required', 'exists:clients,id'],
            'assessor_date' => ['required', 'date'],
            'development'   => ['required', 'string'],
            'detail'        => ['nullable', 'string'],
            'weight'        => ['nullable', 'numeric', 'min:0'],
            'height'        => ['nullable', 'numeric', 'min:0'],
            'oral'          => ['nullable', 'string', 'max:255'],
            'appearance'    => ['nullable', 'string', 'max:255'],
            'wound'         => ['nullable', 'string', 'max:255'],
            'disease'       => ['nullable', 'string', 'max:255'],
            'hygiene'       => ['nullable', 'string', 'max:255'],
            'health'        => ['nullable', 'string', 'max:255'],
            'inoculation'   => ['nullable', 'string', 'max:255'],
            'injection'     => ['nullable', 'string', 'max:255'],
            'vaccination'   => ['nullable', 'string', 'max:255'],
            'contagious'    => ['nullable', 'string', 'max:255'],
            'other'         => ['nullable', 'string', 'max:255'],
            'drug_allergy'  => ['nullable', 'string', 'max:255'],
            'recorder'      => ['required', 'string', 'max:255'],
            'remark'        => ['nullable', 'string'],
        ], [
            // ✅ ข้อความ error ภาษาไทย
            'client_id.required'     => 'กรุณาเลือกเด็กที่ต้องการบันทึกข้อมูล',
            'client_id.exists'       => 'ข้อมูลเด็กไม่ถูกต้อง',
            'assessor_date.required' => 'กรุณาระบุวันที่ตรวจ',
            'assessor_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
            'development.required'   => 'กรุณากรอกข้อมูลการพัฒนา',
            'weight.numeric'         => 'น้ำหนักต้องเป็นตัวเลข',
            'weight.min'             => 'น้ำหนักต้องไม่น้อยกว่า 0',
            'height.numeric'         => 'ส่วนสูงต้องเป็นตัวเลข',
            'height.min'             => 'ส่วนสูงต้องไม่น้อยกว่า 0',
            'recorder.required'      => 'กรุณาระบุชื่อผู้บันทึกข้อมูล',
            'recorder.string'        => 'ชื่อผู้บันทึกต้องเป็นข้อความ',
            'recorder.max'           => 'ชื่อผู้บันทึกต้องไม่เกิน 255 ตัวอักษร',
        ]);

        CheckBody::create($validated);

        return redirect()
            ->route('check_body.add', $request->client_id)
            ->with(['message' => 'บันทึกข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }

    // 🟢 แก้ไขข้อมูล (ใช้ฟอร์มเดิม)
    public function CheckBodyEdit($id)
    {
        $checkbody = CheckBody::findOrFail($id);
        $client = $checkbody->client;
        $checkbodies = CheckBody::where('client_id', $client->id)->latest()->get();

        return view('frontend.client.CheckBody.check_body_add', compact('client', 'checkbodies', 'checkbody'))
            ->with('client_id', $client->id);
    }

    // 🟢 อัปเดตข้อมูล
    public function CheckBodyUpdate(Request $request, $id)
{
     $validated = $request->validate([
            'client_id'     => ['required', 'exists:clients,id'],
            'assessor_date' => ['required', 'date'],
            'development'   => ['required', 'string'],
            'detail'        => ['nullable', 'string'],
            'weight'        => ['nullable', 'numeric', 'min:0'],
            'height'        => ['nullable', 'numeric', 'min:0'],
            'oral'          => ['nullable', 'string', 'max:255'],
            'appearance'    => ['nullable', 'string', 'max:255'],
            'wound'         => ['nullable', 'string', 'max:255'],
            'disease'       => ['nullable', 'string', 'max:255'],
            'hygiene'       => ['nullable', 'string', 'max:255'],
            'health'        => ['nullable', 'string', 'max:255'],
            'inoculation'   => ['nullable', 'string', 'max:255'],
            'injection'     => ['nullable', 'string', 'max:255'],
            'vaccination'   => ['nullable', 'string', 'max:255'],
            'contagious'    => ['nullable', 'string', 'max:255'],
            'other'         => ['nullable', 'string', 'max:255'],
            'drug_allergy'  => ['nullable', 'string', 'max:255'],
            'recorder'      => ['required', 'string', 'max:255'],
            'remark'        => ['nullable', 'string'],
        ], [
            // ✅ ข้อความ error ภาษาไทย
            'client_id.required'     => 'กรุณาเลือกเด็กที่ต้องการบันทึกข้อมูล',
            'client_id.exists'       => 'ข้อมูลเด็กไม่ถูกต้อง',
            'assessor_date.required' => 'กรุณาระบุวันที่ตรวจ',
            'assessor_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
            'development.required'   => 'กรุณากรอกข้อมูลการพัฒนา',
            'weight.numeric'         => 'น้ำหนักต้องเป็นตัวเลข',
            'weight.min'             => 'น้ำหนักต้องไม่น้อยกว่า 0',
            'height.numeric'         => 'ส่วนสูงต้องเป็นตัวเลข',
            'height.min'             => 'ส่วนสูงต้องไม่น้อยกว่า 0',
            'recorder.required'      => 'กรุณาระบุชื่อผู้บันทึกข้อมูล',
            'recorder.string'        => 'ชื่อผู้บันทึกต้องเป็นข้อความ',
            'recorder.max'           => 'ชื่อผู้บันทึกต้องไม่เกิน 255 ตัวอักษร',
        ]);


    // ✅ ถ้าเลือก "สมวัย" → ล้างค่า detail
    if ($validated['development'] === 'สมวัย') {
        $validated['detail'] = null;
    }

    $checkbody = CheckBody::findOrFail($id);
    $checkbody->update($validated);

    return redirect()
        ->route('check_body.add', $checkbody->client_id)
        ->with(['message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
}

    // 🟢 ลบข้อมูล
    public function CheckBodyDelete($id)
    {
        $checkbody = CheckBody::findOrFail($id);
        $clientId = $checkbody->client_id;
        $checkbody->delete();

        return redirect()
            ->route('check_body.add', $clientId)
            ->with(['message' => 'ลบข้อมูลเรียบร้อยแล้ว', 'alert-type' => 'success']);
    }
}