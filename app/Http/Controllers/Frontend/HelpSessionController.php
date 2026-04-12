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
    public function show(Request $request, Client $client)
{
    // =========================
    // PATCH: กันเดา URL (Route Model Binding)
    // =========================
    $client = Client::forUser(auth()->user())->findOrFail($client->id);

    $query = HelpSession::where('client_id', $client->id)
        ->with('items')
        ->orderBy('help_date', 'desc');

    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('help_date', [$request->from, $request->to]);
    } elseif ($request->filled('from')) {
        $query->whereDate('help_date', '>=', $request->from);
    } elseif ($request->filled('to')) {
        $query->whereDate('help_date', '<=', $request->to);
    }

    $sessions = $query->get();
    $grandTotal = $sessions->sum('total_amount');

    return view('frontend.client.helping.help_sessions_show', compact(
        'client',
        'sessions',
        'grandTotal'
    ));
}

    public function store(Request $request, Client $client)
    {
        // =========================
        // PATCH: กันเดา URL (Route Model Binding)
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

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
    ]);

    DB::transaction(function () use ($validated, $client) {
        $session = HelpSession::create([
            'client_id'    => $client->id,
            'help_date'    => $validated['help_date'],
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
                     ->with([
                        'message' => 'บันทึกข้อมูลเรียบร้อย',
                        'alert-type' => 'success'
                     ]);
}

    public function destroy(Client $client, HelpSession $session)
    {
        // =========================
        // PATCH: กันลบของ client คนอื่น
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

        // =========================
        // PATCH: ตรวจว่า session เป็นของ client นี้จริง
        // =========================
        if ($session->client_id !== $client->id) {
            abort(403);
        }

        $session->delete();

        return redirect()->route('help_sessions.show', $client->id)
                         ->with([
                            'message' => 'ลบข้อมูลเรียบร้อย',
                            'alert-type' => 'success'
                         ]);
    }

    public function create(Client $client)
    {
        // =========================
        // PATCH: กันเดา URL
        // =========================
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

        return view('frontend.client.helping.help_sessions_create', compact('client'));
    }


    public function report(Client $client, HelpSession $session)
{
    // =========================
    // PATCH: กันเดา URL (Route Model Binding)
    // =========================
    $client = Client::forUser(auth()->user())->findOrFail($client->id);

    // =========================
    // PATCH: ตรวจว่า session เป็นของ client นี้จริง
    // =========================
    if ($session->client_id !== $client->id) {
        abort(403);
    }

    $session->load('items');

    $grandTotal = $session->items->sum(function ($item) {
        return (float) $item->quantity * (float) $item->unit_price;
    });

    return view('frontend.client.helping.report', compact(
        'client',
        'session',
        'grandTotal'
    ));
}

public function edit(Client $client, HelpSession $session)
{
    // =========================
    // PATCH: กันเข้าดูของ client คนอื่น
    // =========================
    $client = Client::forUser(auth()->user())->findOrFail($client->id);

    if ($session->client_id !== $client->id) {
        abort(403);
    }

    return view('frontend.client.helping.edit', compact('client', 'session'));
}

public function update(Request $request, Client $client, HelpSession $session)
{
    // =========================
    // PATCH: กัน update ของ client คนอื่น
    // =========================
    $client = Client::forUser(auth()->user())->findOrFail($client->id);

    if ($session->client_id !== $client->id) {
        abort(403);
    }

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

    return redirect()->route('help_sessions.show', $client->id)
                     ->with([
                        'message' => 'แก้ไขข้อมูลเรียบร้อย',
                        'alert-type' => 'success'
                     ]);
}


public function reportRange(Request $request, Client $client)
{
    // =========================
    // PATCH: กันเดา URL (Route Model Binding)
    // =========================
    $client = Client::forUser(auth()->user())->findOrFail($client->id);

    $query = HelpSession::where('client_id', $client->id)
        ->with('items')
        ->orderBy('help_date', 'asc');

    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('help_date', [$request->from, $request->to]);
    } elseif ($request->filled('from')) {
        $query->whereDate('help_date', '>=', $request->from);
    } elseif ($request->filled('to')) {
        $query->whereDate('help_date', '<=', $request->to);
    }

    $sessions = $query->get();

    $grandTotal = $sessions->sum(function ($session) {
        return $session->items->sum(function ($item) {
            return (float) $item->quantity * (float) $item->unit_price;
        });
    });

    return view('frontend.client.helping.report_range', compact(
        'client',
        'sessions',
        'grandTotal'
    ));
}
}