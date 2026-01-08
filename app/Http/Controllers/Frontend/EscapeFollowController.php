<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Escape;
use App\Models\EscapeFollow;

class EscapeFollowController extends Controller
{
    // เพิ่มการติดตามใหม่
    public function StoreFollow(Request $request, $escape_id)
    {
        $escape = Escape::findOrFail($escape_id);

        // หาครั้งล่าสุดแล้ว +1
        $lastFollow = EscapeFollow::where('escape_id', $escape_id)
            ->orderByDesc('count')
            ->first();
        $nextCount = $lastFollow ? $lastFollow->count + 1 : 1;

        $data = $request->validate([
            'trace_date'  => 'required|date',
            'trac_no'     => 'required|string',
            'detail'      => 'nullable|string',
            'report_date' => 'nullable|date',
            'stop_date'   => 'nullable|date',
            'punish'      => 'nullable|string',
            'punish_date' => 'nullable|date',
            'remark'      => 'nullable|string',
        ]);

        $data['escape_id'] = $escape->id;
        $data['count']     = $nextCount; // กำหนดอัตโนมัติ

        EscapeFollow::create($data);

        $notification = [
        'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
        'alert-type' => 'success'
    ];

        return redirect()
            ->route('escape.edit', $escape->id)
            ->with($notification);
    }

    // อัปเดตการติดตาม
    public function UpdateFollow(Request $request, $id)
    {
        $follow = EscapeFollow::findOrFail($id);

        $data = $request->validate([
            'trace_date'  => 'required|date',
            'trac_no'     => 'required|string',
            'detail'      => 'nullable|string',
            'report_date' => 'nullable|date',
            'stop_date'   => 'nullable|date',
            'punish'      => 'nullable|string',
            'punish_date' => 'nullable|date',
            'remark'      => 'nullable|string',
        ]);

        // สำหรับ update เราไม่ต้องเปลี่ยน count ให้มันคงเดิม
        $data['count'] = $follow->count;

        $follow->update($data);

        $notification = [
        'message' => 'อัปเดตข้อมูลเรียบร้อยแล้ว',
        'alert-type' => 'success'
    ];

        return redirect()
            ->route('escape.edit', $follow->escape_id)
            ->with($notification);
    }

    // ลบการติดตาม
    public function DeleteFollow($id)
    {
        $follow = EscapeFollow::findOrFail($id);
        $escape_id = $follow->escape_id;
        $follow->delete();

            $notification = [
        'message' => 'ลบข้อมูลเรียบร้อยแล้ว',
        'alert-type' => 'success'
    ];

        return redirect()
            ->route('escape.edit', $escape_id)
            ->with($notification);
    }
}