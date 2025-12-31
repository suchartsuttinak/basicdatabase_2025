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
            'date' => 'required|date',
            'behavior' => 'nullable|string',
            'cause' => 'nullable|string',
            'solution' => 'nullable|string',
            'action' => 'nullable|string',
            'obstacles' => 'nullable|string',
            'result' => 'nullable|string',
            'record_date' => 'nullable|date',
            'recorder' => 'nullable|string|max:100',
            'misbehavior_id' => 'required|integer',
            'client_id' => 'required|integer',
        ]);

        Observe::create($data);

        return redirect()->route('observe.create', $data['client_id'])
                         ->with('success','บันทึกข้อมูลเรียบร้อย');
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
            'date' => 'required|date',
            'behavior' => 'nullable|string',
            'cause' => 'nullable|string',
            'solution' => 'nullable|string',
            'action' => 'nullable|string',
            'obstacles' => 'nullable|string',
            'result' => 'nullable|string',
            'record_date' => 'nullable|date',
            'recorder' => 'nullable|string|max:100',
            'misbehavior_id' => 'required|integer',
            'client_id' => 'required|integer',
        ]);

        $observe->update($data);

        return redirect()->route('observe.create', $data['client_id'])
                         ->with('success','แก้ไขข้อมูลเรียบร้อย');
    }

    // ลบข้อมูล
    public function DeleteObserve($id)
    {
        $observe = Observe::findOrFail($id);
        $client_id = $observe->client_id;
        $observe->delete();

        return redirect()->route('observe.create', $client_id)
                         ->with('success','ลบข้อมูลเรียบร้อย');
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

            return redirect()
                ->route('observe.edit', $data['observe_id'])
                ->with('followup_success', 'บันทึกการติดตามผลเรียบร้อย');
}





    // ลบการติดตามผล
    public function DeleteFollowup($id)
    {
        $followup = ObserveFollowup::findOrFail($id);
        $observe_id = $followup->observe_id;
        $followup->delete();

        return redirect()->route('observe.edit', $observe_id)
                         ->with('followup_success','ลบการติดตามผลเรียบร้อย');
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

        return redirect()->route('observe.edit', $followup->observe_id)
                         ->with('followup_success','แก้ไขการติดตามผลเรียบร้อย');
    }
}