<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Psychiatric;
use App\Models\Psycho;

class PsychiatricController extends Controller
{
    // แสดงฟอร์มเพิ่มข้อมูลใหม่
    public function AddPsychiatric($client_id)
    {
        $psycho = Psycho::all();
        $client = Client::findOrFail($client_id);
        $psychiatrics = Psychiatric::where('client_id', $client->id)
            ->orderBy('sent_date', 'desc')
            ->get();
        $psychiatric = null; // สำหรับเพิ่มใหม่

        return view('frontend.client.psychiatric.psychiatric_create', compact('client', 'client_id', 'psychiatrics', 'psychiatric', 'psycho'));
    }

    // บันทึกข้อมูลใหม่
    public function StorePsychiatric(Request $request)
    {
            $data = $request->validate([
            'sent_date'   => 'required|date',
            'hotpital'    => 'required|string|max:255',
            'psycho_id'   => 'required|exists:psychos,id',
            'diagnose'    => 'nullable|string',
            'appoin_date' => 'nullable|date',
            'drug_no'     => 'required|in:yes,no',
            'drug_name'   => 'nullable|string|max:255',
            'disa_no'     => 'required|in:yes,no',
            'client_id'   => 'required|exists:clients,id',
        ],[
            'sent_date.required'   => 'กรุณาระบุวันที่ส่ง',
            'sent_date.date'       => 'รูปแบบวันที่ส่งไม่ถูกต้อง',
            'hotpital.required'    => 'กรุณาระบุชื่อโรงพยาบาล',
            'hotpital.string'      => 'ชื่อโรงพยาบาลต้องเป็นข้อความ',
            'hotpital.max'         => 'ชื่อโรงพยาบาลต้องไม่เกิน 255 ตัวอักษร',
            'psycho_id.required'   => 'กรุณาเลือกนักจิตวิทยา',
            'psycho_id.exists'     => 'นักจิตวิทยาที่เลือกไม่ถูกต้อง',
            'diagnose.string'      => 'การวินิจฉัยต้องเป็นข้อความ',
            'appoin_date.date'     => 'รูปแบบวันที่นัดหมายไม่ถูกต้อง',
            'drug_no.required'     => 'กรุณาระบุการใช้ยา',
            'drug_no.in'           => 'การใช้ยาต้องเป็น yes หรือ no เท่านั้น',
            'drug_name.string'     => 'ชื่อยาต้องเป็นข้อความ',
            'drug_name.max'        => 'ชื่อยาต้องไม่เกิน 255 ตัวอักษร',
            'disa_no.required'     => 'กรุณาระบุความพิการ',
            'disa_no.in'           => 'ความพิการต้องเป็น yes หรือ no เท่านั้น',
            'client_id.required'   => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists'     => 'ผู้รับบริการที่เลือกไม่ถูกต้อง',
        ]);

        if ($data['drug_no'] === 'no') {
            $data['drug_name'] = null;
        }

        Psychiatric::create($data);

         $notification = array(
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notification);
    }

    // แก้ไขข้อมูล (โหลดฟอร์มพร้อมข้อมูลเดิม)
   public function EditPsychiatricJson($id)
{
    $psychiatric = Psychiatric::findOrFail($id);

    return response()->json([
        'id'         => $psychiatric->id,
        'sent_date'  => \Carbon\Carbon::parse($psychiatric->sent_date)->format('Y-m-d'),
        'hotpital'   => $psychiatric->hotpital,
        'psycho_id'  => $psychiatric->psycho_id,
        'diagnose'   => $psychiatric->diagnose,
        'appoin_date'=> $psychiatric->appoin_date ? \Carbon\Carbon::parse($psychiatric->appoin_date)->format('Y-m-d') : null,
        'drug_no'    => $psychiatric->drug_no,
        'drug_name'  => $psychiatric->drug_name,
        'disa_no'    => $psychiatric->disa_no,
        'client_id'  => $psychiatric->client_id,
    ]);
}

    // อัปเดตข้อมูล
    public function UpdatePsychiatric(Request $request, $id)
    {
            $psychiatric = Psychiatric::findOrFail($id);

            $data = $request->validate([
            'sent_date'   => 'required|date',
            'hotpital'    => 'nullable|string|max:255',
            'psycho_id'   => 'required|exists:psychos,id',
            'diagnose'    => 'nullable|string',
            'appoin_date' => 'nullable|date',
            'drug_no'     => 'required|in:yes,no',
            'drug_name'   => 'nullable|string|max:255',
            'disa_no'     => 'required|in:yes,no',
            'client_id'   => 'required|exists:clients,id',
        ],[
            'sent_date.required'   => 'กรุณาระบุวันที่ส่ง',
            'sent_date.date'       => 'รูปแบบวันที่ส่งไม่ถูกต้อง',
            'hotpital.string'      => 'ชื่อสถานพยาบาลต้องเป็นข้อความ',
            'hotpital.max'         => 'ชื่อสถานพยาบาลต้องไม่เกิน 255 ตัวอักษร',
            'psycho_id.required'   => 'กรุณาเลือกผลการตรวจ',
            'psycho_id.exists'     => 'ผลการตรวจที่เลือกไม่ถูกต้อง',
            'diagnose.string'      => 'การวินิจฉัยต้องเป็นข้อความ',
            'appoin_date.date'     => 'รูปแบบวันที่นัดหมายไม่ถูกต้อง',
            'drug_no.required'     => 'กรุณาระบุการรักษา',
            'drug_no.in'           => 'การรักษาต้องเป็น yes หรือ no เท่านั้น',
            'drug_name.string'     => 'ชื่อยาต้องเป็นข้อความ',
            'drug_name.max'        => 'ชื่อยาต้องไม่เกิน 255 ตัวอักษร',
            'disa_no.required'     => 'กรุณาระบุการขึ้นทะเบียนคนพิการ',
            'disa_no.in'           => 'การขึ้นทะเบียนต้องเป็น yes หรือ no เท่านั้น',
            'client_id.required'   => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists'     => 'ผู้รับบริการที่เลือกไม่ถูกต้อง',
        ]);

        if ($data['drug_no'] === 'no') {
            $data['drug_name'] = null;
        }

         // ✅ ถ้าผู้ใช้ลบชื่อสถานพยาบาลออก ให้ใส่ "ไม่ระบุ"
            if (empty($data['hotpital'])) {
                $data['hotpital'] = 'ไม่ระบุ';
            }

        $psychiatric->update($data);

         $notification = array(
            'message' => 'อัปเดตข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );


        return redirect()->route('psychiatric.create', $psychiatric->client_id)
                         ->with($notification);
    }

    // ลบข้อมูล
    public function DeletePsychiatric($id)
    {
        $psychiatric = Psychiatric::findOrFail($id);
        $clientId = $psychiatric->client_id;
        $psychiatric->delete();

         $notification = array(
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        );


        return redirect()
            ->route('psychiatric.create', $clientId)
            ->with($notification);
    }
}