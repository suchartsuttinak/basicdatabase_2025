<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientHouseTransfer;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientHouseTransferController extends Controller
{
    public function index()
    {
        $clients = Client::forUser(auth()->user())
            ->with('house')
            ->orderBy('first_name')
            ->get();

        $houses = House::orderBy('house_name')->get();

        $caregivers = User::query()
            ->with('houses:id,house_name')
            ->select('id', 'name', 'project_id')
            ->whereHas('houses')
            ->orderBy('name')
            ->get()
            ->flatMap(function ($user) {
                return $user->houses->map(function ($house) use ($user) {
                    return [
                        'house_id' => $house->id,
                        'name' => $user->name,
                    ];
                });
            })
            ->groupBy('house_id')
            ->map(function ($items) {
                return $items->pluck('name')->implode(', ');
            });

        return view('frontend.client_house_transfer.index', compact(
            'clients',
            'houses',
            'caregivers'
        ));
    }

    public function update(Request $request, Client $client)
    {
        $client = Client::forUser(auth()->user())->findOrFail($client->id);

        $validated = $request->validate([
            'house_id' => ['required', 'exists:houses,id'],
            'remark' => ['nullable', 'string', 'max:1000'],
        ]);

        if ((int) $client->house_id === (int) $validated['house_id']) {
            return back()->with('info', 'เด็กอยู่บ้านนี้อยู่แล้ว ไม่มีการเปลี่ยนแปลงข้อมูล');
        }

        DB::transaction(function () use ($client, $validated) {
            $oldHouseId = $client->house_id;
            $newHouseId = $validated['house_id'];

            $caregiver = User::whereHas('houses', function ($query) use ($newHouseId) {
                $query->where('houses.id', $newHouseId);
            })->first();

            ClientHouseTransfer::create([
                'client_id' => $client->id,
                'old_house_id' => $oldHouseId,
                'new_house_id' => $newHouseId,
                'project_id' => auth()->user()->project_id,
                'caregiver_id' => $caregiver?->id,
                'changed_by' => auth()->id(),
                'transfer_date' => now()->toDateString(),
                'remark' => $validated['remark'] ?? null,
            ]);

            $client->update([
                'house_id' => $newHouseId,
            ]);
        });

        return back()->with('success', 'ย้ายบ้านและอัปเดตข้อมูลเด็กเรียบร้อยแล้ว');
    }
}