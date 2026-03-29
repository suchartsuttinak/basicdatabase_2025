<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CheckBody;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckBodyController extends Controller
{
    public function CheckBodyAdd($client_id)
    {
        $client = Client::findOrFail($client_id);

        $checkbodies = CheckBody::where('client_id', $client->id)
            ->orderByDesc('assessor_date')
            ->orderByDesc('id')
            ->get();

        $checkbody = null;

       return view('frontend.client.checkBody.index', compact(
    'client',
    'client_id',
    'checkbodies',
    'checkbody'
));
    }

    public function CheckBodyStore(Request $request)
    {
        $validated = $this->validateCheckBody($request);

        if (($validated['development'] ?? null) === 'สมวัย') {
            $validated['detail'] = null;
        }

        CheckBody::create($validated);

        return redirect()
            ->route('check_body.add', $validated['client_id'])
            ->with([
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success',
            ]);
    }

    public function CheckBodyEdit($id)
    {
        $checkbody = CheckBody::with('client')->findOrFail($id);
        $client = $checkbody->client;

        $checkbodies = CheckBody::where('client_id', $client->id)
            ->orderByDesc('assessor_date')
            ->orderByDesc('id')
            ->get();

        return view('frontend.client.checkBody.index', compact(
            'client',
            'checkbodies',
            'checkbody'
        ))->with('client_id', $client->id);
    }

    public function CheckBodyUpdate(Request $request, $id)
    {
        $checkbody = CheckBody::findOrFail($id);

        $validated = $this->validateCheckBody($request, $checkbody->id);

        if (($validated['development'] ?? null) === 'สมวัย') {
            $validated['detail'] = null;
        }

        $checkbody->update($validated);

        return redirect()
            ->route('check_body.add', $checkbody->client_id)
            ->with([
                'message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success',
            ]);
    }

    public function CheckBodyDelete($id)
    {
        $checkbody = CheckBody::findOrFail($id);
        $clientId = $checkbody->client_id;
        $checkbody->delete();

        return redirect()
            ->route('check_body.add', $clientId)
            ->with([
                'message' => 'ลบข้อมูลเรียบร้อยแล้ว',
                'alert-type' => 'success',
            ]);
    }

    public function CheckBodyReport($id)
    {
        $checkbody = CheckBody::with('client')->findOrFail($id);
        $client = $checkbody->client;

        return view('frontend.client.checkBody.report', compact('checkbody', 'client'));
    }

    private function validateCheckBody(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],

            'assessor_date' => [
                'required',
                'date',
                Rule::unique('check_bodies')
                    ->where(fn ($query) => $query->where('client_id', $request->client_id))
                    ->ignore($ignoreId),
            ],

            'development' => ['required', 'in:สมวัย,ไม่สมวัย'],
            'detail' => ['nullable', 'string'],

            'weight' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],

            'oral' => ['nullable', 'string', 'max:255'],
            'appearance' => ['nullable', 'string', 'max:255'],
            'wound' => ['nullable', 'string', 'max:255'],
            'disease' => ['nullable', 'string', 'max:255'],
            'hygiene' => ['nullable', 'string', 'max:255'],
            'health' => ['nullable', 'string', 'max:255'],
            'inoculation' => ['nullable', 'string', 'max:255'],
            'injection' => ['nullable', 'string', 'max:255'],
            'vaccination' => ['nullable', 'string', 'max:255'],
            'contagious' => ['nullable', 'string', 'max:255'],
            'other' => ['nullable', 'string', 'max:255'],
            'drug_allergy' => ['nullable', 'string', 'max:255'],

            'recorder' => ['required', 'string', 'max:255'],
            'remark' => ['nullable', 'string'],
        ], [
            'client_id.required' => 'กรุณาเลือกผู้รับบริการ',
            'client_id.exists' => 'ข้อมูลผู้รับบริการไม่ถูกต้อง',

            'assessor_date.required' => 'กรุณาระบุวันที่ตรวจ',
            'assessor_date.date' => 'รูปแบบวันที่ตรวจไม่ถูกต้อง',
            'assessor_date.unique' => 'มีข้อมูลตรวจสุขภาพวันที่นี้แล้วสำหรับผู้รับบริการคนนี้',

            'development.required' => 'กรุณาเลือกผลการประเมินพัฒนาการ',
            'development.in' => 'ค่าพัฒนาการไม่ถูกต้อง',

            'weight.numeric' => 'น้ำหนักต้องเป็นตัวเลข',
            'weight.min' => 'น้ำหนักต้องไม่น้อยกว่า 0',

            'height.numeric' => 'ส่วนสูงต้องเป็นตัวเลข',
            'height.min' => 'ส่วนสูงต้องไม่น้อยกว่า 0',

            'recorder.required' => 'กรุณาระบุชื่อผู้ตรวจหรือผู้บันทึก',
            'recorder.max' => 'ชื่อผู้ตรวจหรือผู้บันทึกต้องไม่เกิน 255 ตัวอักษร',
        ]);
    }
}