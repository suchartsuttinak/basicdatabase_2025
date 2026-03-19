<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Problem;
use App\Models\Medical;
use App\Models\Psychiatric;
use App\Models\Accident;
use App\Models\Observe;
use Carbon\Carbon;


class AdminClientController extends Controller
{
     public function Index($id)
    {
        $today = Carbon::today();

        $client = Client::find($id);

        // ✅ รวมการพบแพทย์ (Medical, Psychiatric, Accident ที่มี appointment)
        $appointments = collect();

        // Medical
        $medicalRecords = Medical::where('client_id', $id)
            ->whereDate('appt_date', '>=', $today)
            ->get(['appt_date']);
        foreach ($medicalRecords as $m) {
            $appointments->push([
                'type' => 'พบแพทย์',
                'date' => $m->appt_date
            ]);
        }

        // Psychiatric
        $psychiatricRecords = Psychiatric::where('client_id', $id)
            ->whereDate('appoin_date', '>=', $today)
            ->get(['appoin_date']);
        foreach ($psychiatricRecords as $p) {
            $appointments->push([
                'type' => 'พบจิตแพทย์',
                'date' => $p->appoin_date
            ]);
        }

        // Accident ที่มี appointment
        $accidentAppointments = Accident::where('client_id', $id)
            ->whereNotNull('appointment')
            ->whereDate('appointment', '>=', $today)
            ->get(['appointment','treat_no']);
        foreach ($accidentAppointments as $a) {
            $appointments->push([
                'type' => $a->treat_no,
                'date' => $a->appointment
            ]);
        }

        $appointments = $appointments->sortBy('date');
        $appointmentCount = $appointments->count();

        // ✅ พฤติกรรม (ล่าสุด)
        $observeLatest = Observe::where('client_id', $id)
            ->orderBy('record_date', 'desc')
            ->first();
        $observeDate = $observeLatest ? $observeLatest->record_date : null;

        // ✅ การบาดเจ็บ (เฉพาะ incident_date = วันนี้)
        $accidents = Accident::where('client_id', $id)
            ->whereDate('incident_date', $today)
            ->get();
        $accidentCount = $accidents->count();

        // ✅ วัน เดือน ปี (พ.ศ.)
        $day   = $today->locale('th')->translatedFormat('d');
        $month = $today->locale('th')->translatedFormat('F');
        $year  = $today->year + 543; // ปี พ.ศ.

        return view('admin_client.index.client_index', compact(
            'client',
            'appointmentCount',
            'appointments',
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
        $client = Client::with([
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
            'title'
        ])->findOrFail($id);

        $problems = Problem::all();

        return view('admin_client.index.client_report', compact('client', 'problems'));
    }
}