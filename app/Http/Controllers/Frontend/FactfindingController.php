<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้
use App\Models\Client;
use App\Models\Document;
use App\Models\Factfinding;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FactFindingDocument;
use App\Models\Marital;



class FactfindingController extends Controller
{
    public function FactfindingAdd($client_id)
    {
        // ✅ ดึง client
        $client = Client::findOrFail($client_id);

        // ✅ ตรวจสอบว่ามี factfinding อยู่แล้วหรือไม่
        $factFinding = Factfinding::where('client_id', $client_id)->first();

        if ($factFinding) {
            // ถ้ามีแล้ว → redirect ไปหน้า edit โดยส่ง factfinding_id
            return redirect()->route('factfinding.edit', $factFinding->id)
                             ->with('info', 'มีข้อมูลสอบข้อเท็จจริงอยู่แล้ว จึงเข้าสู่หน้าแก้ไข');
        }

        // ✅ ถ้ายังไม่มี → ไปหน้า add
        $maritals = Marital::all();
        $documents = Document::all();

        return view('frontend.client.factfinding.factfinding_add', compact('client', 'documents', 'maritals'))
            ->with('info', 'เพิ่มข้อมูลสอบข้อเท็จจริง');
    }

   public function FactfindingStore(Request $request)
{
    $validated = $request->validate([
        'client_id'   => 'required|integer',
        'date'        => 'required|date',
        'receive_date'=> 'required|date',
        'fact_name'   => 'required|string|max:255',

        // ✅ เพิ่มฟิลด์อื่น ๆ ที่คุณใช้จริง
        'appearance'  => 'nullable|string',
        'skin'        => 'nullable|string',
        'scar'        => 'nullable|string',
        'disability'  => 'nullable|string',
        'evidence'    => 'nullable|string',
        'sick'        => 'required|in:0,1',
        'sick_detail' => 'nullable|string',
        'treatment'   => 'nullable|string',
        'hospital'    => 'nullable|string',
        'weight'      => 'nullable|numeric',
        'height'      => 'nullable|numeric',
        'hygiene'     => 'nullable|string',
        'oral_health' => 'nullable|string',
        'injury'      => 'nullable|string',
        'marital_id'  => 'required|integer',
        'relation_parent' => 'nullable|string',
        'relation_family' => 'nullable|string',
        'relation_child'  => 'nullable|string',
        'ex_conditions'   => 'nullable|string',
        'in_conditions'   => 'nullable|string',
        'environment'     => 'nullable|string',
        'cause_problem'   => 'nullable|string',
        'need'            => 'nullable|string',
        'information'     => 'nullable|string',
        'diagnosis'       => 'nullable|string',

        'case_history'    => 'nullable|string', // ✅ ปรับจาก required → nullable
        'recorder'        => 'required|string',
        'active'          => 'nullable|boolean',

        'documents'   => 'nullable|array',
        'documents.*' => 'integer',
    ]);

    // ✅ แยก documents ออกมาก่อน
    $documents = $validated['documents'] ?? [];
    unset($validated['documents']);

    // ✅ ดึงข้อมูล Client
    $client = Client::findOrFail($validated['client_id']);

    // ✅ ตรวจสอบว่ามี factfinding อยู่แล้วหรือไม่
    $existing = Factfinding::where('client_id', $validated['client_id'])->first();
    if ($existing) {
        return redirect()
            ->route('factfinding.edit', $existing->id)
            ->with('error', 'มีข้อมูลของผู้รับรายนี้อยู่แล้ว ท่านสามารถแก้ไขแทนการบันทึกใหม่ได้');
    }

    // ✅ บันทึก factfinding โดยไม่ส่ง documents เข้าไป
    $factFinding = Factfinding::create($validated);

    // ✅ แนบ documents ผ่าน pivot
    if (!empty($documents)) {
        foreach ($documents as $docId) {
            FactFindingDocument::create([
                'factfinding_id' => $factFinding->id,
                'document_id'    => (int)$docId,
            ]);
        }
    }

    return redirect()->route('factfinding.edit', $factFinding->id)
                     ->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
}


 public function FactfindingEdit($factfinding_id)
    {
        $factFinding = Factfinding::findOrFail($factfinding_id);
        $client = Client::findOrFail($factFinding->client_id);
        $documents = Document::all();
        $maritals = Marital::all();
        $selectedDocs = $factFinding->documents()->pluck('documents.id')->toArray();

        return view('frontend.client.factfinding.factfinding_edit', compact(
            'client','factFinding','documents','selectedDocs','maritals'
        ));
    }



  public function FactfindingUpdate(Request $request, $factfinding_id)
{
    $validated = $request->validate([
        'client_id'   => 'required|integer',
        'date'        => 'required|date',
        'receive_date'=> 'required|date',
        'fact_name'   => 'required|string|max:255',
        'appearance'  => 'nullable|string',
        'skin'        => 'nullable|string',
        'scar'        => 'nullable|string',
        'disability'  => 'nullable|string',
        'evidence'    => 'nullable|string',
        'sick'        => 'required|in:0,1',
        'sick_detail' => 'nullable|string',
        'treatment'   => 'nullable|string',
        'hospital'    => 'nullable|string',
        'weight'      => 'nullable|numeric',
        'height'      => 'nullable|numeric',
        'hygiene'     => 'nullable|string',
        'oral_health' => 'nullable|string',
        'injury'      => 'nullable|string',
        'marital_id'  => 'required|integer',
        'relation_parent' => 'nullable|string',
        'relation_family' => 'nullable|string',
        'relation_child'  => 'nullable|string',
        'ex_conditions'   => 'nullable|string',
        'in_conditions'   => 'nullable|string',
        'environment'     => 'nullable|string',
        'cause_problem'   => 'nullable|string',
        'need'            => 'nullable|string',
        'information'     => 'nullable|string',
        'diagnosis'       => 'nullable|string',
        'case_history'    => ['required','regex:/^(?=.*[ก-๙a-zA-Z])[ก-๙a-zA-Z0-9\s]+$/u'],
        'recorder'        => 'required|string',
        'active'          => 'nullable|boolean',
        'documents'       => 'nullable|array',
        'documents.*'     => 'integer',
    ]);

    // ✅ ดึง factfinding ตาม factfinding_id
    $factFinding = Factfinding::findOrFail($factfinding_id);

      // ✅ ถ้า sick = 0 ให้ลบค่า sick_detail
    if ($validated['sick'] == 0) {
        $validated['sick_detail'] = null;
    }



    // ✅ เตรียม payload
    $payload = [
        'client_id'   => (int)$validated['client_id'],
        'date'        => $validated['date'],
        'receive_date'=> $validated['receive_date'],
        'fact_name'   => $validated['fact_name'],
        'appearance'  => $validated['appearance'] ?? 'ไม่ระบุ',
        'skin'        => $validated['skin'] ?? 'ไม่ระบุ',
        'scar'        => $validated['scar'] ?? 'ไม่ระบุ',
        'disability'  => $validated['disability'] ?? 'ไม่ระบุ',
        'evidence'    => $validated['evidence'] ?? '',
        'sick'        => $validated['sick'] ?? 0,
        'sick_detail' => $validated['sick_detail'] ?? 'ไม่ระบุ',
        'treatment'   => $validated['treatment'] ?? '',
        'hospital'    => $validated['hospital'] ?? '',
        'weight'      => isset($validated['weight']) ? (float)$validated['weight'] : 0,
        'height'      => isset($validated['height']) ? (float)$validated['height'] : 0,
        'hygiene'     => $validated['hygiene'] ?? 'ไม่ระบุ',
        'oral_health' => $validated['oral_health'] ?? 'ไม่ระบุ',
        'injury'      => $validated['injury'] ?? 'ไม่ระบุ',
        'marital_id'  => $validated['marital_id'] ?? 0,
        'relation_parent' => $validated['relation_parent'] ?? '',
        'relation_family' => $validated['relation_family'] ?? '',
        'relation_child'  => $validated['relation_child'] ?? '',
        'ex_conditions'   => $validated['ex_conditions'] ?? '',
        'in_conditions'   => $validated['in_conditions'] ?? '',
        'environment'     => $validated['environment'] ?? '',
        'cause_problem'   => $validated['cause_problem'] ?? '',
        'need'            => $validated['need'] ?? '',
        'information'     => $validated['information'] ?? '',
        'diagnosis'       => $validated['diagnosis'] ?? '',
        'case_history'    => $validated['case_history'] ?? '',
        'recorder'        => $validated['recorder'] ?? '',
        'active'          => $validated['active'] ?? 1,
    ];

    // ✅ อัปเดต factfinding
    $factFinding->update($payload);

    // ✅ ลบ pivot เดิม
    \App\Models\FactFindingDocument::where('factfinding_id', $factFinding->id)->delete();

    // ✅ เพิ่ม pivot ใหม่
    if (!empty($validated['documents'])) {
        foreach ($validated['documents'] as $docId) {
            \App\Models\FactFindingDocument::create([
                'factfinding_id' => $factFinding->id,
                'document_id'    => (int)$docId,
            ]);
        }
    }

    // ✅ แจ้งเตือน
    $notification = [
        'message'    => 'อัปเดตข้อมูลเรียบร้อยแล้ว',
        'alert-type' => 'success'
    ];

    // ✅ redirect กลับไปหน้า edit โดยใช้ factfinding_id
    return redirect()->route('factfinding.edit', $factFinding->id)
                     ->with($notification);
}
}