<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Validator; // ✅ ต้องมีบรรทัดนี้
use App\Models\Client;
use App\Models\Document;
use App\Models\Factfinding;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FactFindingDocument;


class FactfindingController extends Controller
{
    public function FactfindingAdd($client_id)
    {
        $documents = Document::all();
        $client = Client::findOrFail($client_id);

        return view('frontend.client.factfinding.factfinding_add', compact('client', 'documents'));
    }

    public function FactfindingStore(Request $request)
{
   $validated = $request->validate([
    'client_id'   => 'required|integer',
    'date' => 'required|date',
    'fact_name'   => 'required|string|max:255',

    'appearance'  => 'nullable|string',
    'skin'        => 'nullable|string',
    'scar'        => 'nullable|string',
    'disability'  => 'nullable|string',
    'evidence'    => 'nullable|string',

    'sick'        => 'required|in:0,1',   // 0 = ไม่ป่วย, 1 = ป่วย
    'sick_detail' => 'nullable|string',
    'treatment'   => 'nullable|string',
    'hospital'    => 'nullable|string',

    'weight'      => 'nullable|numeric',
    'height'      => 'nullable|numeric',

    'hygiene'     => 'nullable|string',
    'oral_health' => 'nullable|string',
    'injury'      => 'nullable|string',

   'case_history' => [
    'required',
    'regex:/^(?=.*[ก-๙a-zA-Z])[ก-๙a-zA-Z0-9\s]+$/u'
    ],

    'recorder'    => 'required|string',
    'active'      => 'nullable|boolean',

    'documents'   => 'nullable|array',
    'documents.*' => 'integer',

], [
    // custom messages ภาษาไทย
    'date.required' => 'กรุณากรอก วันที่บันทึก',
    'date.date'     => 'วันที่บันทึก ต้องเป็นรูปแบบวันที่ที่ถูกต้อง',

    'fact_name.required' => 'กรุณากรอก ชื่อข้อเท็จจริง',

    'case_history.required' => 'กรุณากรอก ประวัติความเป็นมา',
    'case_history.regex'    => 'ประวัติความเป็นมา ต้องไม่เป็นตัวเลขอย่างเดียว',

    'recorder.required' => 'กรุณากรอก ผู้บันทึก',

    'sick.required' => 'กรุณาเลือก ประวัติการเจ็บป่วย',
    'sick.in'       => 'กรุณาเลือก มี หรือ ไม่มี',

    'weight.required' => 'กรุณากรอก น้ำหนัก',
    'weight.numeric'  => 'น้ำหนัก ต้องเป็นตัวเลข',
    'height.required' => 'กรุณากรอก ส่วนสูง',
    'height.numeric'  => 'ส่วนสูง ต้องเป็นตัวเลข',

], [
    // custom attributes ภาษาไทย มีไว้เพื่อแสดงชื่อฟิลด์เป็นภาษาไทยในข้อความ error → ทำให้ผู้ใช้เข้าใจง่ายขึ้น

    'client_id'   => 'รหัสลูกค้า',
    'date'        => 'วันที่บันทึก',
    'fact_name'   => 'ชื่อข้อเท็จจริง',
    'appearance'  => 'รูปลักษณ์',
    'skin'        => 'สีผิว',
    'scar'        => 'แผลเป็น',
    'disability'  => 'ความพิการ',
    'evidence'    => 'หลักฐาน',
    'sick'        => 'การเจ็บป่วย',
    'sick_detail' => 'รายละเอียดการเจ็บป่วย',
    'treatment'   => 'การรักษา',
    'hospital'    => 'โรงพยาบาล',
    'weight'      => 'น้ำหนัก',
    'height'      => 'ส่วนสูง',
    'hygiene'     => 'สุขอนามัย',
    'oral_health' => 'สุขภาพช่องปาก',
    'injury'      => 'การบาดเจ็บ',
    'case_history'=> 'ประวัติกรณี',
    'recorder'    => 'ผู้บันทึก',
    'active'      => 'สถานะ',
    'documents'   => 'เอกสาร',
]);
    //End validation rules thai

    // ✅ ดึงข้อมูล Client
    $client = Client::findOrFail($validated['client_id']);

     // 3. ตรวจสอบว่ามี factfinding อยู่แล้วหรือไม่ (One-to-One)
    $existing = Factfinding::where('client_id', $validated['client_id'])->first();
    if ($existing) {
        // ✅ ถ้ามีแล้ว → redirect กลับพร้อมแจ้งเตือน
        return redirect()
            ->route('factfinding.edit', $validated['client_id'])
            ->with('error', 'มีข้อมูลของผู้รับรายนี้อยู่แล้ว ท่านสามารถแก้ไขแทนการบันทึกใหม่ได้');
    }

    // ✅ บันทึก factfinding
    $payload = [
        'client_id'   => (int)$validated['client_id'],
        'date'        => $validated['date'],
        'fact_name'   => $validated['fact_name'],
        'appearance'  => $validated['appearance'] ?? 'ไม่ระบุ',
        'skin'        => $validated['skin'] ?? 'ไม่ระบุ',
        'scar'        => $validated['scar'] ?? 'ไม่ระบุ',
        'disability'  => $validated['disability'] ?? 'ไม่ระบุ',
        'evidence'    => $validated['evidence'] ?? '',
        'sick'        => $validated['sick'] ?? 0,
        'sick_detail' => $validated['sick_detail'] ?? '',
        'treatment'   => $validated['treatment'] ?? '',
        'hospital'    => $validated['hospital'] ?? '',
        'weight'      => isset($validated['weight']) ? (float)$validated['weight'] : 0,
        'height'      => isset($validated['height']) ? (float)$validated['height'] : 0,
        'hygiene'     => $validated['hygiene'] ?? 'ไม่ระบุ',
        'oral_health' => $validated['oral_health'] ?? 'ไม่ระบุ',
        'injury'      => $validated['injury'] ?? 'ไม่ระบุ',
        'case_history'=> $validated['case_history'] ?? '',
        'recorder'    => $validated['recorder'] ?? '',
        'active'      => $validated['active'] ?? 1,
    ];

   // ✅ ส่ง payload เข้าไปใน updateOrCreate
    $factFinding = Factfinding::updateOrCreate(
        ['client_id' => (int)$validated['client_id']],
        $payload
    );


   // ✅ ลบ documents เดิมก่อน แล้วเพิ่มใหม่
\App\Models\FactFindingDocument::where('factfinding_id', $factFinding->id)->delete();

if (!empty($validated['documents'])) {
    foreach ($validated['documents'] as $docId) {
        \App\Models\FactFindingDocument::create([
            'factfinding_id' => $factFinding->id,
            'document_id'    => (int)$docId,
        ]);
    }
}

// ✅ ดึง documents พร้อม relation "document"
$documents = \App\Models\FactFindingDocument::with('document')
    ->where('factfinding_id', $factFinding->id)
    ->get();

     $notification = [
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success'
            ];


return view('frontend.client.factfinding.factfinding_add', [
    'factFinding' => $factFinding,
    'documents'   => $documents,   // ตอน loop ใน blade ใช้ $doc->document->ชื่อฟิลด์
    'client'  => $client,
])->with($notification);

}

    public function FactfindingEdit($id)
{
  
    $client = Client::findOrFail($id);

    // 2. ดึงข้อมูล factfinding ของผู้รับ (One-to-One)
    $factFinding = Factfinding::where('client_id', $id)->firstOrFail();

    // 3. ดึงเอกสารทั้งหมด
    $documents = Document::all();

    // 4. ดึงเอกสารที่เลือกไว้แล้ว (pivot relation)
    // ✅ ระบุ table ให้ชัดเจนเพื่อแก้ ambiguous column
    $selectedDocs = $factFinding->documents()->pluck('documents.id')->toArray();

    // 5. ส่งข้อมูลไปที่ view
    return view('frontend.client.factfinding.factfinding_edit', compact(
        'client',
        'factFinding',
        'documents',
        'selectedDocs'
    ));
  }

  public function FactfindingUpdate(Request $request, $id)
  {
    $validated = $request->validate([
    'client_id'   => 'required|integer',
    'date' => 'required|date',
    'fact_name'   => 'required|string|max:255',

    'appearance'  => 'nullable|string',
    'skin'        => 'nullable|string',
    'scar'        => 'nullable|string',
    'disability'  => 'nullable|string',
    'evidence'    => 'nullable|string',

    'sick'        => 'required|in:0,1',   // 0 = ไม่ป่วย, 1 = ป่วย
    'sick_detail' => 'nullable|string',
    'treatment'   => 'nullable|string',
    'hospital'    => 'nullable|string',

    'weight'      => 'nullable|numeric',
    'height'      => 'nullable|numeric',

    'hygiene'     => 'nullable|string',
    'oral_health' => 'nullable|string',
    'injury'      => 'nullable|string',
   
    'case_history' => [
    'required',
    'regex:/^(?=.*[ก-๙a-zA-Z])[ก-๙a-zA-Z0-9\s]+$/u'
    ],

    'recorder'    => 'required|string',

    'active'      => 'nullable|boolean',

    'documents'   => 'nullable|array',
    'documents.*' => 'integer',

], [
    // custom messages ภาษาไทย
    'date.required' => 'กรุณากรอก วันที่บันทึก',
    'date.date'     => 'วันที่บันทึก ต้องเป็นรูปแบบวันที่ที่ถูกต้อง',

    'fact_name.required' => 'กรุณากรอก ชื่อผู้นำส่ง',
    'fact_name.string'   => 'ชื่อผู้นำส่ง ต้องเป็นตัวอักษร',
    'fact_name.max'      => 'ชื่อผู้นำส่ง ต้องไม่เกิน 255 ตัวอักษร',

    'case_history.required' => 'กรุณากรอก ประวัติความเป็นมา',
    'case_history.regex'    => 'ประวัติความเป็นมา ต้องไม่เป็นตัวเลขอย่างเดียว',

    'recorder.required' => 'กรุณากรอก ผู้บันทึก',

    'sick.required' => 'กรุณาเลือก ประวัติการเจ็บป่วย',
    'sick.in'       => 'กรุณาเลือก มี หรือ ไม่มี',

    'weight.required' => 'กรุณากรอก น้ำหนัก',
    'weight.numeric'  => 'น้ำหนัก ต้องเป็นตัวเลข',
    'height.required' => 'กรุณากรอก ส่วนสูง',
    'height.numeric'  => 'ส่วนสูง ต้องเป็นตัวเลข',

], [
    // custom attributes ภาษาไทย มีไว้เพื่อแสดงชื่อฟิลด์เป็นภาษาไทยในข้อความ error → ทำให้ผู้ใช้เข้าใจง่ายขึ้น

    'client_id'   => 'รหัสลูกค้า',
    'date'        => 'วันที่บันทึก',
    'fact_name'   => 'ชื่อข้อเท็จจริง',
    'appearance'  => 'รูปลักษณ์',
    'skin'        => 'สีผิว',
    'scar'        => 'แผลเป็น',
    'disability'  => 'ความพิการ',
    'evidence'    => 'หลักฐาน',
    'sick'        => 'การเจ็บป่วย',
    'sick_detail' => 'รายละเอียดการเจ็บป่วย',
    'treatment'   => 'การรักษา',
    'hospital'    => 'โรงพยาบาล',
    'weight'      => 'น้ำหนัก',
    'height'      => 'ส่วนสูง',
    'hygiene'     => 'สุขอนามัย',
    'oral_health' => 'สุขภาพช่องปาก',
    'injury'      => 'การบาดเจ็บ',
    'case_history'=> 'ประวัติกรณี',
    'recorder'    => 'ผู้บันทึก',
    'active'      => 'สถานะ',
    'documents'   => 'เอกสาร',
]);
    //End validation rules thai
    //End validation rules thai

    $clientId = (int) $validated['client_id'];
    $client = Client::findOrFail($clientId);
    $factFinding = Factfinding::where('client_id', $clientId)->firstOrFail();

  // ✅ บันทึก factfinding
    $payload = [
        'client_id'   => (int)$validated['client_id'],
        'date'        => $validated['date'],
        'fact_name'   => $validated['fact_name'],
        'appearance'  => $validated['appearance'] ?? 'ไม่ระบุ',
        'skin'        => $validated['skin'] ?? 'ไม่ระบุ',
        'scar'        => $validated['scar'] ?? 'ไม่ระบุ',
        'disability'  => $validated['disability'] ?? 'ไม่ระบุ',
        'evidence'    => $validated['evidence'] ?? '',
        'sick'        => $validated['sick'] ?? 0,
        'sick_detail' => $validated['sick_detail'] ?? '',
        'treatment'   => $validated['treatment'] ?? '',
        'hospital'    => $validated['hospital'] ?? '',
        'weight'      => isset($validated['weight']) ? (float)$validated['weight'] : 0,
        'height'      => isset($validated['height']) ? (float)$validated['height'] : 0,
        'hygiene'     => $validated['hygiene'] ?? 'ไม่ระบุ',
        'oral_health' => $validated['oral_health'] ?? 'ไม่ระบุ',
        'injury'      => $validated['injury'] ?? 'ไม่ระบุ',
        'case_history'=> $validated['case_history'] ?? '',
        'recorder'    => $validated['recorder'] ?? '',
        'active'      => $validated['active'] ?? 1,
    ];

        $factFinding->update($payload);

        // ลบ pivot เดิม
        \App\Models\FactFindingDocument::where('factfinding_id', $factFinding->id)->delete();

        // เพิ่ม pivot ใหม่
        if (!empty($validated['documents'])) {
            foreach ($validated['documents'] as $docId) {
                \App\Models\FactFindingDocument::create([
                    'factfinding_id' => $factFinding->id,
                    'document_id'    => (int) $docId,
                ]);
            }
        }

        // แจ้งเตือน
        $notification = [
            'message'    => 'อัปเดตข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        // redirect
        return redirect()
            ->route('factfinding.edit', $clientId) // หรือเปลี่ยนเป็น edit/index ตามที่เหมาะสม
            ->with($notification);
    }
}