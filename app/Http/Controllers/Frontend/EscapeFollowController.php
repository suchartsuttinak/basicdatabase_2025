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

        $data = $request->validate([
            'trace_date'  => 'required|date',
            'count'       => 'required|integer',
            'trac_no'     => 'required|string',
            'detail'      => 'nullable|string',
            'report_date' => 'nullable|date',
            'stop_date'   => 'nullable|date',
            'punish'      => 'nullable|string',
            'punish_date' => 'nullable|date',
            'remark'      => 'nullable|string',
        ]);

        $data['escape_id'] = $escape->id;

        EscapeFollow::create($data);

        return redirect()
            ->route('escape.edit', $escape->id)
            ->with(['message' => 'เพิ่มข้อมูลการติดตามเรียบร้อย', 'alert-type' => 'success']);
    }

    public function UpdateFollow(Request $request, $id)
{
    $follow = EscapeFollow::findOrFail($id);

    $data = $request->validate([
        'trace_date'  => 'required|date',
        'count'       => 'required|integer',
        'trac_no'     => 'required|string',
        'detail'      => 'nullable|string',
        'report_date' => 'nullable|date',
        'stop_date'   => 'nullable|date',
        'punish'      => 'nullable|string',
        'punish_date' => 'nullable|date',
        'remark'      => 'nullable|string',
    ]);

    $follow->update($data);

    return redirect()
        ->route('escape.edit', $follow->escape_id)
        ->with(['success' => 'อัปเดตข้อมูลการติดตามเรียบร้อย']);
}



     public function DeleteFollow($id)
{
    $follow = EscapeFollow::findOrFail($id);
    $escape_id = $follow->escape_id;
    $follow->delete();

    return redirect()
        ->route('escape.edit', $escape_id)
        ->with(['success' => 'ลบข้อมูลการติดตามเรียบร้อย']);
}
}