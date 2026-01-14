<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refer;
use App\Models\Client;
use App\Models\Translate;

class ReferController extends Controller
{
    /**
     * แสดงตาราง refer ของ client ที่เลือก
     */
    public function index($client_id)
    {
        $client     = Client::findOrFail($client_id);
        $translates = Translate::all();
        $refers     = Refer::with(['client','translate'])
                           ->where('client_id', $client_id)
                           ->latest()
                           ->get();

        return view('frontend.client.refer.refer_index', compact('translates','refers','client'));
    }

    /**
     * บันทึกข้อมูล refer ใหม่
     */
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

        // ✅ บันทึก refer
        $refer = Refer::create($validated);

        // ✅ อัพเดทสถานะ client → refer
        $client = Client::findOrFail($validated['client_id']);
        $client->update(['release_status' => 'refer']);

        // ✅ redirect กลับไปหน้า index ของ refer
        return redirect()->route('refers.index', $client->id)
                         ->with([
                             'message'    => 'บันทึกการจำหน่ายเรียบร้อยแล้ว',
                             'alert-type' => 'success'
                         ]);
    }

    /**
     * Restore สถานะ client กลับเป็น show
     */
    public function restore($id)
    {
        $refer = Refer::with('client')->findOrFail($id);

        if (!$refer->client) {
            return $this->errorResponse('ไม่พบข้อมูล client ที่เกี่ยวข้อง', 404);
        }

        // ✅ ถ้า client มีสถานะ show อยู่แล้ว
        if ($refer->client->release_status === 'show') {
            return $this->errorResponse('ผู้รับรายนี้มีสถานะอยู่แล้ว', 400, 'warning');
        }

        // ✅ อัพเดทสถานะกลับเป็น show
        $refer->client->update(['release_status' => 'show']);

        if (request()->ajax()) {
            return response()->json(['message' => 'Restore สำเร็จ']);
        }

        return redirect()->route('client.show', $refer->client_id)
                         ->with([
                             'message'    => 'คืนค่าสถานะ ' . $refer->client->fullname . ' เรียบร้อยแล้ว',
                             'alert-type' => 'success'
                         ]);
    }

    /**
     * Helper สำหรับ error response
     */
    private function errorResponse($message, $status = 400, $alertType = 'error')
    {
        if (request()->ajax()) {
            return response()->json(['message' => $message], $status);
        }

        return back()->with([
            'message'    => $message,
            'alert-type' => $alertType
        ]);
    }
}