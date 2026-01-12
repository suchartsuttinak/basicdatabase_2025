<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refer;
use App\Models\Client;
use App\Models\Translate;

class ReferController extends Controller
{
    // แสดงตาราง refer ของทุก client ที่เคยจำหน่าย
    public function index()
    {
        $translates = Translate::all();
        $refers = Refer::with('client','translate')->latest()->get();

        return view('frontend.client.refer.refer_index', compact('translates','refers'));
    }

    // บันทึกข้อมูล refer ใหม่
    public function store(Request $request)
    {
        $validated = $request->validate([
            'refer_date'   => 'required|date',
            'translate_id' => 'required|exists:translates,id',
            'destination'  => 'nullable|string',
            'address'      => 'nullable|string',
            'guardian'     => 'required|in:มี,ไม่มี',
            'parent_name'  => 'nullable|string',
            'parent_tel'   => 'nullable|string',
            'member'       => 'nullable|string',
            'teacher'      => 'nullable|string',
            'remark'       => 'nullable|string',
            'client_id'    => 'required|exists:clients,id',
        ]);

        Refer::create($validated);

        // อัพเดทสถานะ client
        $client = Client::findOrFail($validated['client_id']);
        $client->update(['release_status' => 'refer']);

        return redirect()->route('refers.index')
                         ->with([
                             'message' => 'บันทึกการจำหน่ายเรียบร้อยแล้ว',
                             'alert-type' => 'success'
                         ]);
    }

    // Restore สถานะกลับเป็น show
    public function restore($id)
    {
        $refer = Refer::with('client')->findOrFail($id);

        if (!$refer->client) {
            if (request()->ajax()) {
                return response()->json(['message' => 'ไม่พบข้อมูล client ที่เกี่ยวข้อง'], 404);
            }
            return back()->with([
                'message' => 'ไม่พบข้อมูล client ที่เกี่ยวข้อง',
                'alert-type' => 'error'
            ]);
        }

        // ✅ ตรวจสอบว่ามีสถานะ show อยู่แล้ว
        if ($refer->client->release_status === 'show') {
            if (request()->ajax()) {
                return response()->json(['message' => 'ผู้รับรายนี้มีสถานะ Active อยู่แล้ว'], 400);
            }
            return back()->with([
                'message' => 'ผู้รับรายนี้มีสถานะอยู่แล้ว',
                'alert-type' => 'warning'
            ]);
        }

        // ✅ ถ้าไม่ใช่ show → อัพเดทเป็น show
        $refer->client->update(['release_status' => 'show']);

        if (request()->ajax()) {
            return response()->json(['message' => 'Restore สำเร็จ']);
        }

        $notification = [
            'message' => 'คืนค่าสถานะ ' . $refer->client->fullname . ' เรียบร้อยแล้ว',
            'alert-type' => 'success'
        ];

        return redirect()->route('client.show', $refer->client_id)->with($notification);
    }
}