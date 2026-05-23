<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpSession;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\CaseActivity;

class HelpSessionController extends Controller
{
    public function show(Request $request, Client $client)
    {
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

    public function create(Client $client)
    {
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

        return view('frontend.client.helping.help_sessions_create', compact('client'));
    }

   public function store(Request $request, Client $client)
        {
            $client = Client::forUser(auth()->user())->findOrFail($client->id);

            $validated = $request->validate([
                'help_date' => [
                    'required',
                    'date',
                    Rule::unique('help_sessions', 'help_date')
                        ->where(fn ($query) => $query->where('client_id', $client->id)),
                ],

                'items' => 'required|array|min:1',
                'items.*.item_name'  => 'required|string',
                'items.*.quantity'   => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
            ], [
                'help_date.required' => 'กรุณากรอกวันที่',
                'help_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
                'help_date.unique'   => 'วันนี้มีการบันทึกช่วยเหลือแล้ว ห้ามซ้ำ',

                'items.required' => 'กรุณาเพิ่มรายการช่วยเหลืออย่างน้อย 1 รายการ',
                'items.array'    => 'รูปแบบรายการช่วยเหลือไม่ถูกต้อง',
                'items.min'      => 'กรุณาเพิ่มรายการช่วยเหลืออย่างน้อย 1 รายการ',

                'items.*.item_name.required'  => 'กรุณากรอกชื่อรายการ',
                'items.*.quantity.required'   => 'กรุณากรอกจำนวน',
                'items.*.quantity.integer'    => 'จำนวนต้องเป็นตัวเลขจำนวนเต็ม',
                'items.*.quantity.min'        => 'จำนวนต้องไม่น้อยกว่า 1',
                'items.*.unit_price.required' => 'กรุณากรอกราคา/หน่วย',
                'items.*.unit_price.numeric'  => 'ราคา/หน่วยต้องเป็นตัวเลข',
                'items.*.unit_price.min'      => 'ราคา/หน่วยต้องไม่น้อยกว่า 0',
            ]);

            DB::transaction(function () use ($validated, $client) {
                $session = HelpSession::create([
                    'client_id'    => $client->id,
                    'help_date'    => $validated['help_date'],
                    'total_amount' => 0,
                ]);

                $total = 0;
                $itemNames = [];

                foreach ($validated['items'] as $item) {
                    $itemTotal = $item['quantity'] * $item['unit_price'];

                    $session->items()->create([
                        'item_name'   => $item['item_name'],
                        'quantity'    => $item['quantity'],
                        'unit_price'  => $item['unit_price'],
                        'total_price' => $itemTotal,
                    ]);

                    $total += $itemTotal;
                    $itemNames[] = $item['item_name'];
                }

                $session->update([
                    'total_amount' => $total,
                ]);

                CaseActivity::where('client_id', $client->id)
                ->where('module', 'help_session')
                ->delete();

                CaseActivity::record([
                    'client_id'   => $client->id,
                    'module'      => 'help_session',
                    'type'        => 'success',
                    'title'       => 'บันทึกการช่วยเหลือสิ่งของ/เครื่องใช้',
                    'description' => 'รายการ: ' . implode(', ', array_slice($itemNames, 0, 3)) .
                                    (count($itemNames) > 3 ? ' และรายการอื่น ๆ' : '') .
                                    ' | มูลค่ารวม: ' . number_format($total, 2) . ' บาท',
                   'occurred_at' => now(),
                    'icon'        => 'bi-box-seam',
                    'url'         => route('help_sessions.show', $client->id),
                ]);
            });

            return redirect()->route('help_sessions.show', $client->id)
                ->with([
                    'message' => 'บันทึกข้อมูลเรียบร้อย',
                    'alert-type' => 'success',
                ]);
        }

    public function edit(Client $client, HelpSession $session)
    {
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

        if ($session->client_id !== $client->id) {
            abort(403);
        }

        return view('frontend.client.helping.edit', compact('client', 'session'));
    }

    public function update(Request $request, Client $client, HelpSession $session)
    {
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

        if ($session->client_id !== $client->id) {
            abort(403);
        }

        $validated = $request->validate([
            'help_date' => [
                'required',
                'date',
                Rule::unique('help_sessions', 'help_date')
                    ->where(fn ($query) => $query->where('client_id', $client->id))
                    ->ignore($session->id),
            ],

            'items' => 'required|array|min:1',
            'items.*.item_name'  => 'required|string',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ], [
            'help_date.required' => 'กรุณากรอกวันที่',
            'help_date.date'     => 'รูปแบบวันที่ไม่ถูกต้อง',
            'help_date.unique'   => 'วันนี้มีการบันทึกช่วยเหลือแล้ว ห้ามซ้ำ',

            'items.required' => 'กรุณาเพิ่มรายการช่วยเหลืออย่างน้อย 1 รายการ',
            'items.array'    => 'รูปแบบรายการช่วยเหลือไม่ถูกต้อง',
            'items.min'      => 'กรุณาเพิ่มรายการช่วยเหลืออย่างน้อย 1 รายการ',

            'items.*.item_name.required'  => 'กรุณากรอกชื่อรายการ',
            'items.*.quantity.required'   => 'กรุณากรอกจำนวน',
            'items.*.quantity.integer'    => 'จำนวนต้องเป็นตัวเลขจำนวนเต็ม',
            'items.*.quantity.min'        => 'จำนวนต้องไม่น้อยกว่า 1',
            'items.*.unit_price.required' => 'กรุณากรอกราคา/หน่วย',
            'items.*.unit_price.numeric'  => 'ราคา/หน่วยต้องเป็นตัวเลข',
            'items.*.unit_price.min'      => 'ราคา/หน่วยต้องไม่น้อยกว่า 0',
        ]);

        DB::transaction(function () use ($validated, $session) {
            $session->update([
                'help_date' => $validated['help_date'],
            ]);

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

                        $session->update([
                    'total_amount' => $total,
                ]);

                $itemNames = collect($validated['items'])->pluck('item_name')->toArray();

                CaseActivity::where('client_id', $session->client_id)
                    ->where('module', 'help_session')
                    ->delete();

                CaseActivity::record([
                    'client_id'   => $session->client_id,
                    'module'      => 'help_session',
                    'type'        => 'success',
                    'title'       => 'แก้ไขการช่วยเหลือสิ่งของ/เครื่องใช้',
                    'description' => 'วันที่ช่วยเหลือ: ' . ($validated['help_date'] ?? '-') .
                                    ' | รายการ: ' . implode(', ', array_slice($itemNames, 0, 3)) .
                                    (count($itemNames) > 3 ? ' และรายการอื่น ๆ' : '') .
                                    ' | มูลค่ารวม: ' . number_format($total, 2) . ' บาท',
                    'occurred_at' => now(),
                    'icon'        => 'bi-box-seam',
                    'url'         => route('help_sessions.show', $session->client_id),
                ]);
                        });

        return redirect()->route('help_sessions.show', $client->id)
            ->with([
                'message' => 'แก้ไขข้อมูลเรียบร้อย',
                'alert-type' => 'success',
            ]);
    }

    public function destroy(Client $client, HelpSession $session)
    {
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

        if ($session->client_id !== $client->id) {
            abort(403);
        }

       CaseActivity::where('client_id', $client->id)
            ->where('module', 'help_session')
            ->delete();

        $session->delete();

        return redirect()->route('help_sessions.show', $client->id)
            ->with([
                'message' => 'ลบข้อมูลเรียบร้อย',
                'alert-type' => 'success',
            ]);
    }

    public function report(Client $client, HelpSession $session)
    {
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

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

    public function reportRange(Request $request, Client $client)
    {
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