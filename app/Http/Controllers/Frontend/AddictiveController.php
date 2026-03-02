<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Addictive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;

class AddictiveController extends Controller
{
      // โหลดฟอร์ม + ข้อมูลเดิม
    public function AddAddictive($client_id)
    {
        $client = Client::findOrFail($client_id);

        // ดึงข้อมูลการตรวจสารเสพติดทั้งหมดของ client
        $addictives = Addictive::where('client_id', $client->id)
            ->orderBy('date', 'desc')
            ->get();

        $addictive = null; // สำหรับเพิ่มใหม่

        return view('frontend.client.addictive.addictive_create', compact('client', 'client_id', 'addictives', 'addictive'));
    }

    // บันทึกข้อมูลใหม่
    public function StoreAddictive(Request $request)
    {
       $data = $request->validate([
        'date'       => 'required|date',
        'exam'       => 'required|in:0,1',
        'refer'      => 'nullable|in:1,2',
        'record'     => 'nullable|string',
        'recorder'   => 'required|string|max:255',
        'client_id'  => 'required|exists:clients,id',
    ]);

    // นับจำนวนครั้งล่าสุด
    $latestCount = Addictive::where('client_id', $data['client_id'])->max('count') ?? 0;
    $nextCount = $latestCount + 1;

    // ตรวจสอบว่ามี count นี้อยู่แล้วหรือไม่
    $exists = Addictive::where('client_id', $data['client_id'])
                       ->where('count', $nextCount)
                       ->exists();

    if ($exists) {
        return redirect()->back()->with([
            'message' => 'ไม่สามารถบันทึกข้อมูลซ้ำได้ (ครั้งที่ ' . $nextCount . ' มีอยู่แล้ว)',
            'alert-type' => 'error'
        ]);
    }

    $data['count'] = $nextCount;

    if ($data['exam'] == 0) {
        $data['refer'] = null;
    }

    Addictive::create($data);

    return redirect()->back()->with([
        'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
        'alert-type' => 'success'
    ]);


    }

    // แก้ไขข้อมูล (โหลดฟอร์มพร้อมข้อมูลเดิม)
    public function EditAddictive($id)
    {
        $addictive = Addictive::findOrFail($id);
        $client = $addictive->client;

        $addictives = Addictive::where('client_id', $client->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('frontend.client.addictive.addictive_create', compact('client', 'addictives', 'addictive'));
    }

    // อัปเดตข้อมูล
    public function UpdateAddictive(Request $request, $id)
    {
        $addictive = Addictive::findOrFail($id);

        $data = $request->validate([
            'date'       => 'required|date',
            'exam'       => 'required|in:0,1',
            'refer'      => 'nullable|in:1,2',
            'record'     => 'nullable|string',
            'recorder'   => 'required|string|max:255',
        ]);

        // ถ้า exam = 0 (ไม่พบ) ให้ refer เป็น null
        if ($data['exam'] == 0) {
            $data['refer'] = null;
        }

        $addictive->update($data);

        $notification = [
            'message' => 'อัปเดตข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->route('addictive.create', $addictive->client_id)
                         ->with($notification);
    }

    // ลบข้อมูล
    public function DeleteAddictive($id)
    {
        $addictive = Addictive::findOrFail($id);
        $clientId = $addictive->client_id;
        $addictive->delete();

        $notification = [
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->route('addictive.create', $clientId)
                         ->with($notification);
    }
}

