<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Observe;
use App\Models\Misbehavior;
use App\Models\ObserveFollowup;

class ObserveController extends Controller
{
    // หน้าเพิ่มใหม่
    public function AddObserve($client_id)
    {
        $client = Client::findOrFail($client_id);
        $misbehaviors = Misbehavior::all();
        $observes = Observe::with('followups')
            ->where('client_id', $client_id)
            ->orderBy('date', 'desc')
            ->get();
        $observe = null; // สำหรับเพิ่มใหม่

        return view('frontend.client.observe.observe_create', compact('client','client_id','misbehaviors','observes','observe'));
    }

    // บันทึกข้อมูลใหม่
    public function StoreObserve(Request $request)
    {
        $data = $request->validate([
            'date'          => 'required|date',
            'behavior'      => 'required|string',
            'cause'         => 'required|string',
            'solution'      => 'required|string',
            'action'        => 'required|string',
            'obstacles'     => 'nullable|string',
            'result'        => 'required|string',
            'record_date'   => 'required|date',
            'recorder'      => 'nullable|string|max:100',
            'misbehavior_id'=> 'required|integer',
            'client_id'     => 'required|integer',
        ], [
            'date.required'        => 'กรุณาระบุวันที่',
            'date.date'            => 'วันที่ไม่ถูกต้อง',

            'behavior.required'    => 'กรุณาระบุพฤติกรรม',
            'behavior.string'      => 'พฤติกรรมต้องเป็นข้อความ',

            'cause.required'       => 'กรุณาระบุสาเหตุ',
            'cause.string'         => 'สาเหตุต้องเป็นข้อความ',

            'solution.required'    => 'กรุณาระบุแนวทางแก้ไข',
            'solution.string'      => 'แนวทางแก้ไขต้องเป็นข้อความ',

            'action.required'      => 'กรุณาระบุการดำเนินการ',
            'action.string'        => 'การดำเนินการต้องเป็นข้อความ',

            'obstacles.string'     => 'อุปสรรคต้องเป็นข้อความ',

            'result.required'      => 'กรุณาระบุผลการดำเนินการ',
            'result.string'        => 'ผลการดำเนินการต้องเป็นข้อความ',

            'record_date.required' => 'กรุณาระบุวันที่บันทึก',
            'record_date.date'     => 'วันที่บันทึกไม่ถูกต้อง',

            'recorder.string'      => 'ผู้บันทึกต้องเป็นข้อความ',
            'recorder.max'         => 'ชื่อผู้บันทึกต้องไม่เกิน 100 ตัวอักษร',

            'misbehavior_id.required' => 'กรุณาเลือกประเภทพฤติกรรมไม่เหมาะสม',
            'misbehavior_id.integer'  => 'รหัสพฤติกรรมต้องเป็นตัวเลข',

            'client_id.required'   => 'กรุณาเลือกนักเรียน',
            'client_id.integer'    => 'รหัสนักเรียนต้องเป็นตัวเลข',
        ]);
        Observe::create($data);
         // ส่งข้อความ success ไปที่ session โดยตรง
            return redirect()->route('observe.create', $data['client_id'])
            ->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }           



    // หน้าแก้ไข
    public function EditObserve($id)
    {
        $observe = Observe::with('followups')->findOrFail($id);
        $client = $observe->client;
        $misbehaviors = Misbehavior::all();
        $observes = Observe::with('followups')
            ->where('client_id', $client->id)
            ->orderBy('date','desc')
            ->get();

        return view('frontend.client.observe.observe_create', compact('client','misbehaviors','observes','observe'));
    }

    // อัปเดตข้อมูล
    public function UpdateObserve(Request $request, $id)
    {
        $observe = Observe::findOrFail($id);

        $data = $request->validate([
            'date'          => 'required|date',
            'behavior'      => 'required|string',
            'cause'         => 'required|string',
            'solution'      => 'required|string',
            'action'        => 'required|string',
            'obstacles'     => 'nullable|string',
            'result'        => 'required|string',
            'record_date'   => 'required|date',
            'recorder'      => 'nullable|string|max:100',
            'misbehavior_id'=> 'required|integer',
            'client_id'     => 'required|integer',
        ], [
            'date.required'        => 'กรุณาระบุวันที่',
            'date.date'            => 'วันที่ไม่ถูกต้อง',

            'behavior.required'    => 'กรุณาระบุพฤติกรรม',
            'behavior.string'      => 'พฤติกรรมต้องเป็นข้อความ',

            'cause.required'       => 'กรุณาระบุสาเหตุ',
            'cause.string'         => 'สาเหตุต้องเป็นข้อความ',

            'solution.required'    => 'กรุณาระบุแนวทางแก้ไข',
            'solution.string'      => 'แนวทางแก้ไขต้องเป็นข้อความ',

            'action.required'      => 'กรุณาระบุการดำเนินการ',
            'action.string'        => 'การดำเนินการต้องเป็นข้อความ',

            'obstacles.string'     => 'อุปสรรคต้องเป็นข้อความ',

            'result.required'      => 'กรุณาระบุผลการดำเนินการ',
            'result.string'        => 'ผลการดำเนินการต้องเป็นข้อความ',

            'record_date.required' => 'กรุณาระบุวันที่บันทึก',
            'record_date.date'     => 'วันที่บันทึกไม่ถูกต้อง',

            'recorder.string'      => 'ผู้บันทึกต้องเป็นข้อความ',
            'recorder.max'         => 'ชื่อผู้บันทึกต้องไม่เกิน 100 ตัวอักษร',

            'misbehavior_id.required' => 'กรุณาเลือกประเภทพฤติกรรมไม่เหมาะสม',
            'misbehavior_id.integer'  => 'รหัสพฤติกรรมต้องเป็นตัวเลข',

            'client_id.required'   => 'กรุณาเลือกนักเรียน',
            'client_id.integer'    => 'รหัสนักเรียนต้องเป็นตัวเลข',
        ]);

        $observe->update($data);

     

       // ส่งข้อความ success ไปที่ session โดยตรง
    return redirect()->route('observe.create', $data['client_id'])
                     ->with('success', 'อัปเดตข้อมูลเรียบร้อย');
    }

    // ลบข้อมูล
    public function DeleteObserve($id)
    {
        $observe = Observe::findOrFail($id);
        $client_id = $observe->client_id;
        $observe->delete();

        $notification = [
            'message' => 'ลบข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

        return redirect()->route('observe.create', $client_id)
                         ->with($notification);
    }

    // บันทึกการติดตามผล
    public function StoreFollowup(Request $request)
    {
            $data = $request->validate([
                'observe_id'      => 'required|integer|exists:observes,id',
                'followup_date'   => 'required|date',
                'followup_action' => 'nullable|string',
                'followup_result' => 'nullable|string',
            ]);

            $observe = Observe::findOrFail($data['observe_id']);
            $data['followup_count'] = $observe->followups()->count() + 1;

            ObserveFollowup::create($data);

             $notification = [
            'message' => 'บันทึกข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

            return redirect()
                ->route('observe.edit', $data['observe_id'])
                ->with($notification);
        }

    // ลบการติดตามผล
    public function DeleteFollowup($id)
    {
        $followup = ObserveFollowup::findOrFail($id);
        $observe_id = $followup->observe_id;
        $followup->delete();

        $notification = [
            'message' => 'ลบข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

        return redirect()->route('observe.edit', $observe_id)
                         ->with($notification);
    }

    // แก้ไขการติดตามผล
    public function EditFollowup($id)
{
    $followup = ObserveFollowup::findOrFail($id);
    $observe = $followup->observeRelation; // ใช้ชื่อ relation ที่ไม่ชนกับ Laravel

    if (!$observe) {
        return redirect()->back()->with('error', 'ไม่พบข้อมูลพฤติกรรมที่สัมพันธ์กับการติดตามผลนี้');
    }

    $client = $observe->client;
    $misbehaviors = Misbehavior::all();
    $observes = Observe::with('followups')
        ->where('client_id', $client->id)
        ->orderBy('date','desc')
        ->get();

    return view('frontend.client.observe.observe_create', compact(
        'client','misbehaviors','observes','observe','followup'
    ));
}


    // อัปเดตการติดตามผล
    public function UpdateFollowup(Request $request, $id)
    {
        $followup = ObserveFollowup::findOrFail($id);

        $data = $request->validate([
            'followup_date' => 'required|date',
            'followup_count' => 'required|integer|min:1',
            'followup_action' => 'nullable|string',
            'followup_result' => 'nullable|string',
        ]);

        $followup->update($data);

          $notification = [
            'message' => 'อัปเดตข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

        return redirect()->route('observe.edit', $followup->observe_id)
                         ->with($notification);
    }
}