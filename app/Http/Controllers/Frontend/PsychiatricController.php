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
            'hotpital'    => 'nullable|string|max:255',
            'psycho_id'   => 'required|exists:psychos,id', // ✅ แก้ตรงนี้
            'diagnose'    => 'nullable|string',
            'appoin_date' => 'nullable|date',
            'drug_no'     => 'required|in:yes,no',
            'drug_name'   => 'nullable|string|max:255',
            'disa_no'     => 'required|in:yes,no',
            'client_id'   => 'required|exists:clients,id',
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
    public function EditPsychiatric($id)
    {
        $psychiatric = Psychiatric::findOrFail($id);
        $client = $psychiatric->client;
        $psychiatrics = Psychiatric::where('client_id', $client->id)
            ->orderBy('sent_date', 'desc')
            ->get();
        $psycho = Psycho::all();

        return view('frontend.client.psychiatric.psychiatric_create', compact('client', 'psychiatrics', 'psychiatric', 'psycho'));
    }

    // อัปเดตข้อมูล
    public function UpdatePsychiatric(Request $request, $id)
    {
        $psychiatric = Psychiatric::findOrFail($id);

        $data = $request->validate([
            'sent_date'   => 'required|date',
            'hotpital'    => 'nullable|string|max:255',
            'psycho_id'   => 'required|exists:psychos,id', // ✅ แก้ตรงนี้
            'diagnose'    => 'nullable|string',
            'appoin_date' => 'nullable|date',
            'drug_no'     => 'required|in:yes,no',
            'drug_name'   => 'nullable|string|max:255',
            'disa_no'     => 'required|in:yes,no',
        ]);

        if ($data['drug_no'] === 'no') {
            $data['drug_name'] = null;
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