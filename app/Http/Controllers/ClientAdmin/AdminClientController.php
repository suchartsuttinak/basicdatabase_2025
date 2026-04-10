<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\Accident;
use App\Models\Client;
use App\Models\Medical;
use App\Models\Observe;
use App\Models\Problem;
use App\Models\Psychiatric;
use Carbon\Carbon;

class AdminClientController extends Controller
{
    /**
     * ดึง client ที่ user มีสิทธิ์เท่านั้น
     */
    protected function findAuthorizedClient(int $id, array $with = []): Client
    {
        $user = auth()->user();

        $query = Client::query();

        if (!empty($with)) {
            $query->with($with);
        }

        $client = $query->findOrFail($id);

        // admin เห็นได้ทั้งหมด
        if ($user && $user->isAdmin()) {
            return $client;
        }

        if (!$user) {
            abort(403, 'กรุณาเข้าสู่ระบบ');
        }

        $user->loadMissing('houses');

        $allowedHouseIds = $user->houses
            ->pluck('id')
            ->map(fn ($houseId) => (int) $houseId)
            ->unique()
            ->values()
            ->toArray();

        abort_unless(
            !empty($allowedHouseIds) && in_array((int) $client->house_id, $allowedHouseIds, true),
            403,
            'คุณไม่มีสิทธิ์เข้าถึงข้อมูลผู้รับบริการรายนี้'
        );

        return $client;
    }

    public function Index($id)
    {
        $today = Carbon::today();

        $client = $this->findAuthorizedClient((int) $id, [
            'educationRecords',
            'educationRecords.education',
            'educationRecords.institution',
            'problems',
            'house',
            'title',
            'national',
            'religion',
            'marital',
            'occupation',
            'income',
            'education',
            'contact',
            'status',
            'project',
            'target',
            'province',
            'district',
            'sub_district',
            'originProvince',
            'originDistrict',
            'originSubDistrict',
            'father',
            'mother',
            'spouse',
            'relative',
            'members',
            'files',
            'vaccinations',
            'refers',
        ]);

        // รวมการพบแพทย์
        $appointments = collect();

        $medicalRecords = Medical::where('client_id', $client->id)
            ->whereDate('appt_date', '>=', $today)
            ->get(['appt_date']);

        foreach ($medicalRecords as $m) {
            $appointments->push([
                'type' => 'พบแพทย์',
                'date' => $m->appt_date,
            ]);
        }

        $psychiatricRecords = Psychiatric::where('client_id', $client->id)
            ->whereDate('appoin_date', '>=', $today)
            ->get(['appoin_date']);

        foreach ($psychiatricRecords as $p) {
            $appointments->push([
                'type' => 'พบจิตแพทย์',
                'date' => $p->appoin_date,
            ]);
        }

        $accidentAppointments = Accident::where('client_id', $client->id)
            ->whereNotNull('appointment')
            ->whereDate('appointment', '>=', $today)
            ->get(['appointment', 'treat_no']);

        foreach ($accidentAppointments as $a) {
            $appointments->push([
                'type' => $a->treat_no ?: 'นัดหมายการรักษา',
                'date' => $a->appointment,
            ]);
        }

        $appointments = $appointments->sortBy('date')->values();
        $appointmentCount = $appointments->count();

        // พฤติกรรมล่าสุด
        $observeLatest = Observe::where('client_id', $client->id)
            ->orderBy('date', 'desc')
            ->first();

        $observeDate = $observeLatest ? $observeLatest->date : null;

        // การบาดเจ็บวันนี้
        $accidents = Accident::where('client_id', $client->id)
            ->whereDate('incident_date', $today)
            ->get();

        $accidentCount = $accidents->count();

        $day = $today->locale('th')->translatedFormat('d');
        $month = $today->locale('th')->translatedFormat('F');
        $year = $today->year + 543;

        return view('admin_client.index.client_index', compact(
            'client',
            'appointmentCount',
            'appointments',
            'observeLatest',
            'observeDate',
            'accidentCount',
            'accidents',
            'day',
            'month',
            'year'
        ));
    }

    public function ClientReport($id)
    {
        $client = $this->findAuthorizedClient((int) $id, [
            'problems',
            'province',
            'district',
            'sub_district',
            'national',
            'religion',
            'marital',
            'occupation',
            'income',
            'education',
            'contact',
            'project',
            'status',
            'house',
            'target',
            'title',
            'originProvince',
            'originDistrict',
            'originSubDistrict',
            'members.education',
            'members.occupation',
            'members.income',
            'father',
            'mother',
            'relative',
            'spouse',
        ]);

        $factFinding = \App\Models\Factfinding::with([
            'marital',
            'documents',
        ])->where('client_id', $client->id)->first();

        $problems = Problem::all();

        return view('admin_client.index.client_report', compact(
            'client',
            'problems',
            'factFinding'
        ));
    }
}