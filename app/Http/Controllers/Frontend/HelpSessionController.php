<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpSession;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

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
        'help_date' => 'required|date',
        'items.*.item_name' => 'required|string',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
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

    return redirect()->route('help_sessions.show', $client->id)
                     ->with('success', 'บันทึกการช่วยเหลือเรียบร้อย');
}



    public function destroy(Client $client, HelpSession $session)
    {
        $session->delete();

        return redirect()->route('help_sessions.show', $client->id)
                         ->with('success', 'ลบการช่วยเหลือเรียบร้อย');
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
        'help_date' => 'required|date',
        'items.*.item_name' => 'required|string',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ]);

    // อัปเดตวันที่
    $session->update([
        'help_date' => $validated['help_date'],
    ]);

    // ลบรายการเดิมทั้งหมด
    $session->items()->delete();

    $total = 0;
    foreach ($validated['items'] as $itemData) {
        $itemTotal = $itemData['quantity'] * $itemData['unit_price'];
        $session->items()->create([
            'item_name' => $itemData['item_name'],
            'quantity' => $itemData['quantity'],
            'unit_price' => $itemData['unit_price'],
            'total_price' => $itemTotal,
        ]);
        $total += $itemTotal;
    }

    // อัปเดตยอดรวม
    $session->update(['total_amount' => $total]);

    return redirect()->route('help_sessions.show', $client->id)
                     ->with('success', 'แก้ไขการช่วยเหลือเรียบร้อยแล้ว');
}
}