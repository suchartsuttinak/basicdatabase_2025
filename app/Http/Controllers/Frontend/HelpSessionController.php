<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpSession;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HelpSessionController extends Controller
{
    public function show(Client $client)
    {
       $sessions = HelpSession::where('client_id', $client->id)
        ->with('items')
        ->orderBy('help_date', 'desc')
        ->get();

    // รวมยอดทั้งหมดของ client รายนี้
    $grandTotal = $sessions->sum('total_amount');

    return view('frontend.client.helping.help_sessions_show', compact('client', 'sessions', 'grandTotal'));


    }

    public function store(Request $request, Client $client)
    {
      $validated = $request->validate([
        'help_date' => [
            'required',
            'date',
            Rule::unique('help_sessions', 'help_date')
                ->where(fn($query) => $query->where('client_id', $client->id)),
        ],
        'items.*.item_name' => 'required|string',
        'items.*.quantity'  => 'required|integer|min:1',
        'items.*.unit_price'=> 'required|numeric|min:0',
    ], [
        'help_date.required' => 'กรุณากรอกวันที่',
        'help_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
        'help_date.unique'   => 'วันที่นี้มีการบันทึกช่วยเหลือแล้ว ห้ามซ้ำ',
        // … ข้อความ error อื่น ๆ …
    ]);



    DB::transaction(function () use ($validated, $client) {
        $session = HelpSession::create([
            'client_id'    => $client->id,
            'help_date'    => $validated['help_date'], // ✅ ใช้วันที่จากฟอร์ม
            'total_amount' => 0,
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $session->items()->create([
                'item_name'   => $item['item_name'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'total_price' => $itemTotal,
            ]);
            $total += $itemTotal;
        }

        $session->update(['total_amount' => $total]);
    });

    $notification = [
            'message' => 'บันทึกข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

    return redirect()->route('help_sessions.show', $client->id)
                     ->with($notification);
}



    public function destroy(Client $client, HelpSession $session)
    {
        $session->delete();

        $notification = [
            'message' => 'ลบข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

        return redirect()->route('help_sessions.show', $client->id)
                         ->with($notification);
    }

    public function create(Client $client)
    {
        return view('frontend.client.helping.help_sessions_create', compact('client'));
    }


public function edit(Client $client, HelpSession $session)
{
    return view('frontend.client.helping.edit', compact('client', 'session'));


}

public function update(Request $request, Client $client, HelpSession $session)
{
    $validated = $request->validate([
        'help_date' => [
            'required',
            'date',
            Rule::unique('help_sessions', 'help_date')
                ->where(fn($query) => $query->where('client_id', $client->id))
                ->ignore($session->id),
        ],
        'items.*.item_name' => 'required|string',
        'items.*.quantity'  => 'required|integer|min:1',
        'items.*.unit_price'=> 'required|numeric|min:0',
    ], [
        'help_date.required' => 'กรุณากรอกวันที่',
        'help_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
        'help_date.unique'   => 'วันที่นี้มีการบันทึกช่วยเหลือแล้ว ห้ามซ้ำ',
        'items.*.item_name.required' => 'กรุณากรอกรายการ',
        'items.*.quantity.required'  => 'กรุณากรอกจำนวน',
        'items.*.unit_price.required'=> 'กรุณากรอกราคา',
    ]);

    DB::transaction(function () use ($validated, $session) {
        $session->update(['help_date' => $validated['help_date']]);
        $session->items()->delete();

        $total = 0;
        foreach ($validated['items'] as $itemData) {
            $itemTotal = $itemData['quantity'] * $itemData['unit_price'];
            $session->items()->create([
                'item_name'   => $itemData['item_name'],
                'quantity'    => $itemData['quantity'],
                'unit_price'  => $itemData['unit_price'],
                'total_price' => $itemTotal,
            ]);
            $total += $itemTotal;
        }

        $session->update(['total_amount' => $total]);
    });

     $notification = [
            'message' => 'แก้ไขข้อมูลเรียบร้อย',
            'alert-type' => 'success'
        ];

    return redirect()->route('help_sessions.show', $client->id)
                     ->with($notification);
}


}