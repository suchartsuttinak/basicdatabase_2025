<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Absent;
use App\Models\Accident;
use App\Models\Escape;
use App\Models\Education;
use App\Models\Problem;
use App\Models\Medical;
use App\Models\Psychiatric;
use App\Models\Refer; // PATCH: เพิ่ม Refer สำหรับแจ้งเตือนรายการจำหน่ายรออนุมัติ
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $yearMin       = $request->input('year_min', null);
        $yearMax       = $request->input('year_max', null);
        $month         = $request->input('month', null);
        $gender        = $request->input('gender', null);
        $ageMin        = $request->input('age_min', 1);
        $ageMax        = $request->input('age_max', 99);
        $education     = $request->input('education', null);
        $institutionId = $request->input('institution_id', null);
        $releaseStatus = $request->input('release_status', 'show');
        $problemId     = $request->input('problem', null);

        // ✅ เพิ่มตัวแปรสำหรับเดือน/ปีเริ่มต้นและสิ้นสุด
        $startMonth = $request->input('start_month', null);
        $startYear  = $request->input('start_year', null);
        $endMonth   = $request->input('end_month', null);
        $endYear    = $request->input('end_year', null);

        $query = Client::with([
            'educationRecords' => function ($q) use ($education, $institutionId) {
                if ($education) {
                    $q->where('education_id', $education);
                }
                if ($institutionId) {
                    $q->where('institution_id', $institutionId);
                }
                $q->with(['education', 'semester', 'institution']);
            },
            'problems'
        ]);

        // ✅ กรองตามช่วงเดือน/ปี (start → end)
        if ($startMonth && $startYear && $endMonth && $endYear) {
            $startYearAD = $startYear - 543;
            $endYearAD   = $endYear - 543;

            $startDate = Carbon::createFromDate($startYearAD, $startMonth, 1)->startOfMonth();
            $endDate   = Carbon::createFromDate($endYearAD, $endMonth, 1)->endOfMonth();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($yearMin && $yearMax) {
            // fallback: กรองตามปี พ.ศ.
            $query->whereBetween('created_at', [
                ($yearMin - 543) . '-01-01',
                ($yearMax - 543) . '-12-31'
            ]);
        }

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($ageMin && $ageMax) {
            $query->whereBetween('birth_date', [
                now()->subYears($ageMax),
                now()->subYears($ageMin)
            ]);
        }

        if ($education) {
            $query->whereHas('educationRecords', function ($q) use ($education) {
                $q->where('education_id', $education);
            });
        }

        if ($institutionId) {
            $query->whereHas('educationRecords', function ($q) use ($institutionId) {
                $q->where('institution_id', $institutionId);
            });
        }

        if ($problemId) {
            $query->whereHas('problems', function ($q) use ($problemId) {
                $q->where('problems.id', $problemId);
            });
        }

        // =========================
        // PATCH: รองรับการกรอง release_status แบบเดิมทั้งหมด
        // และรองรับค่าใหม่ pending_refer โดยไม่กระทบ flow เดิม
        // =========================
        if (!empty($releaseStatus) && $releaseStatus !== 'all') {
            $query->whereIn('release_status', (array) $releaseStatus);
        }

        $clients = $query->get();

        $maleCount   = $clients->where('gender', 'male')->count();
        $femaleCount = $clients->where('gender', 'female')->count();

        $educationCounts = [];
        foreach ($clients as $client) {
            if ($client->educationRecords->isNotEmpty()) {
                $eduName = $client->educationRecords->first()->education->education_name ?? 'ไม่ระบุ';
                if (!isset($educationCounts[$eduName])) {
                    $educationCounts[$eduName] = 0;
                }
                $educationCounts[$eduName]++;
            }
        }

        $today        = Carbon::today();
        $fiveDaysLater = Carbon::today()->addDays(5);

        // ✅ ขาดเรียนวันนี้
        $absentRecords = Absent::with('client')
            ->whereDate('absent_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();

        $absentCount = $absentRecords->count();
        $absentNames = $absentRecords->map(fn($record) => $record->client->fullname)->toArray();

        // ✅ การบาดเจ็บวันนี้
        $accidentRecords = Accident::with('client')
            ->whereDate('incident_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();

        $accidentCount = $accidentRecords->count();
        $accidentNames = $accidentRecords->map(fn($record) => $record->client->fullname)->toArray();

        // ✅ หลบหนีวันนี้
        $escapeRecords = Escape::with('client')
            ->whereDate('retire_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();

        $escapeCount = $escapeRecords->count();
        $escapeNames = $escapeRecords->map(fn($record) => $record->client->fullname)->toArray();

        // ✅ การนัดหมายแพทย์ล่วงหน้า 5 วัน
        $appointments = collect();

        // Medical
        $medicalRecords = Medical::with('client')
            ->whereBetween('appt_date', [$today, $fiveDaysLater])
            ->get();

        foreach ($medicalRecords as $m) {
            $age = Carbon::parse($m->client->birth_date)->age;
            $appointments->push([
                'fullname' => $m->client->fullname,
                'age'      => $age,
                'type'     => 'พบแพทย์',
                'date'     => $m->appt_date
            ]);
        }

        // Psychiatric
        $psychiatricRecords = Psychiatric::with('client')
            ->whereBetween('appoin_date', [$today, $fiveDaysLater])
            ->get();

        foreach ($psychiatricRecords as $p) {
            $age = Carbon::parse($p->client->birth_date)->age;
            $appointments->push([
                'fullname' => $p->client->fullname,
                'age'      => $age,
                'type'     => 'พบจิตแพทย์',
                'date'     => $p->appoin_date
            ]);
        }

        // Accident ที่มี appointment
        $accidentAppointments = Accident::with('client')
            ->whereNotNull('appointment')
            ->whereBetween('appointment', [$today, $fiveDaysLater])
            ->get();

        foreach ($accidentAppointments as $a) {
            $age = Carbon::parse($a->client->birth_date)->age;
            $appointments->push([
                'fullname' => $a->client->fullname,
                'age'      => $age,
                'type'     => $a->treat_no,
                'date'     => $a->appointment
            ]);
        }

        $appointments     = $appointments->sortBy('date');
        $appointmentCount = $appointments->count();

        $educations = Education::all();
        $problems   = Problem::all();

        // =========================
        // PATCH: รายการจำหน่ายรออนุมัติ
        // แสดงเฉพาะ admin / executive
        // ไม่กระทบผู้ใช้งานกลุ่มอื่น
        // =========================
        $pendingReferApprovals = collect();

        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'executive'])) {
            $pendingReferApprovals = Refer::with(['client', 'translate'])
                ->where('approve_status', 'pending')
                ->whereHas('client', function ($query) {
                    $query->where('release_status', 'pending_refer');
                })
                ->whereIn('client_id', Client::forUser(auth()->user())->pluck('id'))
                ->latest()
                ->get();
        }

        return view('admin.index', [
            'clients'          => $clients,
            'yearMin'          => $yearMin ?? '',
            'yearMax'          => $yearMax ?? '',
            'month'            => $month ?? '',
            'gender'           => $gender ?? '',
            'ageMin'           => $ageMin ?? '',
            'ageMax'           => $ageMax ?? '',
            'education'        => $education ?? '',
            'institution_id'   => $institutionId ?? '',
            'releaseStatus'    => $releaseStatus ?? [],
            'problem'          => $problemId ?? '',
            'maleCount'        => $maleCount,
            'femaleCount'      => $femaleCount,
            'educationCounts'  => $educationCounts,
            'absentCount'      => $absentCount,
            'absentNames'      => $absentNames,
            'accidentCount'    => $accidentCount,
            'accidentNames'    => $accidentNames,
            'escapeCount'      => $escapeCount,
            'escapeNames'      => $escapeNames,

            // ✅ ส่ง Carbon object ไปเลย
            'today'            => $today,

            'educations'       => $educations,
            'problems'         => $problems,
            'startMonth'       => $startMonth ?? '',
            'startYear'        => $startYear ?? '',
            'endMonth'         => $endMonth ?? '',
            'endYear'          => $endYear ?? '',

            // ✅ การนัดหมายแพทย์ล่วงหน้า 5 วัน
            'appointments'     => $appointments,
            'appointmentCount' => $appointmentCount,

            // =========================
            // PATCH: ส่งรายการจำหน่ายรออนุมัติไปหน้า dashboard
            // =========================
            'pendingReferApprovals' => $pendingReferApprovals,
        ]);
    }
}