<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Client;
use App\Models\Income;
use App\Models\Member;
use App\Models\Education;
use App\Models\Occupation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function AddMember($client_id)
    {
     // ดึง client พร้อมสมาชิก
    $client = Client::with('members')->findOrFail($client_id);

    // ถ้ามีสมาชิกแล้ว → ส่งไปหน้า edit พร้อมแจ้งเตือน
    if ($client->members->count() > 0) {
        $notification = [
            'message' => 'มีข้อมูลสมาชิกครอบครัวแล้ว กรุณาแก้ไขข้อมูล',
            'alert-type' => 'info'
        ];

        return redirect()
            ->route('member.show', $client_id)
            ->with($notification);
    }

    // ถ้ายังไม่มีสมาชิก → แสดงฟอร์มเพิ่มใหม่
    $educations = Education::all();
    $occupations = Occupation::all();
    $incomes = Income::all();

    return view('frontend.client.member.member_create',
        compact('client','educations','occupations','incomes'));

    }

    public function ShowMember($client_id)
    {
        $client = Client::findOrFail($client_id);

        $members = Member::with(['education', 'occupation', 'income'])
                         ->where('client_id', $client_id)
                         ->get();

        return view('frontend.client.member.member_show', compact('client', 'members'));
    }

    public function StoreMember(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'members' => 'required|array',
            'members.*.fullname' => 'required|string|max:255',
            'members.*.member_age' => 'required|integer|min:0',
            'members.*.education_id' => 'required|integer',
            'members.*.relationship' => 'required|string|max:100',
            'members.*.occupation_id' => 'required|integer',
            'members.*.income_id' => 'required|integer',
            'members.*.remark' => 'nullable|string|max:255',
        ]);

        $client_id = $request->client_id;

        foreach ($request->members as $memberData) {
            Member::create([
                'client_id'     => $client_id,
                'fullname'      => $memberData['fullname'],
                'member_age'    => $memberData['member_age'],
                'education_id'  => $memberData['education_id'],
                'relationship'  => $memberData['relationship'],
                'occupation_id' => $memberData['occupation_id'],
                'income_id'     => $memberData['income_id'],
                'remark'        => $memberData['remark'] ?? null,
            ]);
        }

        $notification = [
            'message' => 'บันทึกข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

        // ✅ เปลี่ยนให้กลับไปหน้า edit ของ client เดิม
        return redirect()
            ->route('member.show', $client_id)
            ->with($notification);
    }

    public function EditMember($id)
    {
        // ดึง Client พร้อมสมาชิกครอบครัวทั้งหมด
        $client = Client::with('members')->findOrFail($id);

        $educations = Education::all();
        $occupations = Occupation::all();
        $incomes = Income::all();

        return view('frontend.client.member.member_edit', compact(
            'client','educations','occupations','incomes'
        ));
    }

    public function UpdateMember(Request $request, $id)
{
    $request->validate([
        'client_id' => 'required|integer|exists:clients,id',
        'members' => 'required|array',
        'members.*.fullname' => 'required|string|max:255',
        'members.*.member_age' => 'required|integer|min:0',
        'members.*.education_id' => 'required|integer',
        'members.*.relationship' => 'required|string|max:100',
        'members.*.occupation_id' => 'required|integer',
        'members.*.income_id' => 'required|integer',
        'members.*.remark' => 'nullable|string|max:255',
    ]);

    $client = Client::findOrFail($id);

    // ✅ ลบสมาชิกเดิมออกก่อน แล้วเพิ่มใหม่ (วิธีง่ายสุด)
    $client->members()->delete();

    foreach ($request->members as $memberData) {
        $client->members()->create($memberData);
    }

    $notification = [
        'message' => 'แก้ไขข้อมูลเรียบร้อย',
        'alert-type' => 'success'
    ];

    return redirect()
        ->route('member.show', $client->id)
        ->with($notification);
}
}