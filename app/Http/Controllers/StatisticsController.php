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
use App\Models\Refer;
use App\Models\Project;
use App\Models\CaseActivity;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $yearMin        = $request->input('year_min');
        $yearMax        = $request->input('year_max');
        $month          = $request->input('month');
        $gender         = $request->input('gender');
        $ageMin         = $request->input('age_min', 0);
        $ageMax         = $request->input('age_max', 99);
        $educationStart = $request->input('education_start');
        $educationEnd   = $request->input('education_end');
        $institutionId  = $request->input('institution_id');
        $releaseStatus  = $request->input('release_status', 'show');
        $problemId      = $request->input('problem');
        $projectId      = $request->input('project_id');

        $startMonth = $request->input('start_month');
        $startYear  = $request->input('start_year');
        $endMonth   = $request->input('end_month');
        $endYear    = $request->input('end_year');

                $query = Client::forUser(auth()->user())
                ->with([
                    'educationRecords' => function ($q) use ($educationStart, $educationEnd, $institutionId) {
                        if ($educationStart && $educationEnd) {
                            $start = min((int) $educationStart, (int) $educationEnd);
                            $end   = max((int) $educationStart, (int) $educationEnd);

                            $q->whereBetween('education_id', [$start, $end]);
                        } elseif ($educationStart) {
                            $q->where('education_id', (int) $educationStart);
                        } elseif ($educationEnd) {
                            $q->where('education_id', (int) $educationEnd);
                        }

                        if ($institutionId) {
                            $q->where('institution_id', $institutionId);
                        }

                        $q->with(['education', 'semester', 'institution'])
                            ->leftJoin('semesters', 'education_records.semester_id', '=', 'semesters.id')
                            ->select('education_records.*', 'semesters.semester_name as semester_label')
                            ->orderByDesc('education_records.record_date')
                            ->orderByDesc('education_records.id');
                    },
                
                'problems',
            ]);

        if (!empty($projectId) && $projectId !== 'all') {
            $query->where('project_id', $projectId);
        }

        if ($startMonth && $startYear && $endMonth && $endYear) {
            $startDate = Carbon::createFromDate($startYear - 543, $startMonth, 1)->startOfMonth();
            $endDate   = Carbon::createFromDate($endYear - 543, $endMonth, 1)->endOfMonth();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($yearMin && $yearMax) {
            $query->whereBetween('created_at', [
                ($yearMin - 543) . '-01-01',
                ($yearMax - 543) . '-12-31',
            ]);
        }

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($ageMin !== null && $ageMax !== null) {
            $query->whereBetween('birth_date', [
                now()->subYears((int) $ageMax)->startOfDay(),
                now()->subYears((int) $ageMin)->endOfDay(),
            ]);
        }

        if ($educationStart && $educationEnd) {
            $start = min((int) $educationStart, (int) $educationEnd);
            $end   = max((int) $educationStart, (int) $educationEnd);

            $query->whereHas('educationRecords', function ($q) use ($start, $end) {
                $q->whereBetween('education_id', [$start, $end]);
            });
        } elseif ($educationStart) {
            $query->whereHas('educationRecords', function ($q) use ($educationStart) {
                $q->where('education_id', (int) $educationStart);
            });
        } elseif ($educationEnd) {
            $query->whereHas('educationRecords', function ($q) use ($educationEnd) {
                $q->where('education_id', (int) $educationEnd);
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

        if (!empty($releaseStatus) && $releaseStatus !== 'all') {
            $query->where('release_status', $releaseStatus);
        }

        $clients = $query->get();

        $maleCount   = $clients->where('gender', 'male')->count();
        $femaleCount = $clients->where('gender', 'female')->count();

        $educationCounts = [];

        foreach ($clients as $client) {
            if ($client->educationRecords->isNotEmpty()) {
                $eduName = $client->educationRecords->first()->education->education_name ?? 'ไม่ระบุ';
                $educationCounts[$eduName] = ($educationCounts[$eduName] ?? 0) + 1;
            }
        }

        $today          = Carbon::today();
        $fiveDaysLater = Carbon::today()->addDays(5);

        $absentRecords = Absent::with('client')
            ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
            ->whereDate('absent_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();

        $absentCount = $absentRecords->count();
        $absentNames = $absentRecords
            ->filter(fn ($record) => $record->client)
            ->map(fn ($record) => $record->client->fullname)
            ->toArray();

        $accidentRecords = Accident::with('client')
            ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
            ->whereDate('incident_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();

        $accidentCount = $accidentRecords->count();
        $accidentNames = $accidentRecords
            ->filter(fn ($record) => $record->client)
            ->map(fn ($record) => $record->client->fullname)
            ->toArray();

        $escapeRecords = Escape::with('client')
            ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
            ->whereDate('retire_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();

        $escapeCount = $escapeRecords->count();
        $escapeNames = $escapeRecords
            ->filter(fn ($record) => $record->client)
            ->map(fn ($record) => $record->client->fullname)
            ->toArray();

        $appointments = collect();

        $medicalRecords = Medical::with('client')
            ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
            ->whereBetween('appt_date', [$today, $fiveDaysLater])
            ->get();

        foreach ($medicalRecords as $m) {
            if (!$m->client) {
                continue;
            }

            $appointments->push([
                'fullname' => $m->client->fullname,
                'age'      => Carbon::parse($m->client->birth_date)->age,
                'type'     => 'พบแพทย์',
                'date'     => $m->appt_date,
            ]);
        }

        $psychiatricRecords = Psychiatric::with('client')
            ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
            ->whereBetween('appoin_date', [$today, $fiveDaysLater])
            ->get();

        foreach ($psychiatricRecords as $p) {
            if (!$p->client) {
                continue;
            }

            $appointments->push([
                'fullname' => $p->client->fullname,
                'age'      => Carbon::parse($p->client->birth_date)->age,
                'type'     => 'พบจิตแพทย์',
                'date'     => $p->appoin_date,
            ]);
        }

        $accidentAppointments = Accident::with('client')
            ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
            ->whereNotNull('appointment')
            ->whereBetween('appointment', [$today, $fiveDaysLater])
            ->get();

        foreach ($accidentAppointments as $a) {
            if (!$a->client) {
                continue;
            }

            $appointments->push([
                'fullname' => $a->client->fullname,
                'age'      => Carbon::parse($a->client->birth_date)->age,
                'type'     => $a->treat_no ?: 'นัดติดตามอุบัติเหตุ',
                'date'     => $a->appointment,
            ]);
        }

        $appointments = $appointments->sortBy('date')->values();
        $appointmentCount = $appointments->count();

        $pendingReferApprovals = collect();

        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'executive'], true)) {
            $pendingReferApprovals = Refer::with(['client', 'translate'])
                ->where('approve_status', 'pending')
                ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
                ->whereHas('client', function ($query) {
                    $query->where('release_status', 'pending_refer');
                })
                ->latest()
                ->get();
        }

        $latestCaseActivities = CaseActivity::with(['client', 'user'])
            ->whereNotNull('client_id')
            ->whereNotNull('occurred_at')
            ->whereIn('client_id', Client::forUser(auth()->user())->select('id'))
            ->whereHas('client', function ($q) {
                $q->where('release_status', 'show');
            })
            ->orderByDesc('occurred_at')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $educations = Education::orderBy('id')->get();
        $problems   = Problem::orderBy('problem_name')->get();
        $projects   = Project::orderBy('project_name')->get();

        return view('admin.index', [
            'clients'               => $clients,
            'yearMin'               => $yearMin ?? '',
            'yearMax'               => $yearMax ?? '',
            'month'                 => $month ?? '',
            'gender'                => $gender ?? '',
            'ageMin'                => $ageMin,
            'ageMax'                => $ageMax,
            'educationStart'        => $educationStart ?? '',
            'educationEnd'          => $educationEnd ?? '',
            'institution_id'        => $institutionId ?? '',
            'releaseStatus'         => $releaseStatus ?? 'show',
            'problem'               => $problemId ?? '',
            'projectId'             => $projectId ?? '',
            'projects'              => $projects,
            'maleCount'             => $maleCount,
            'femaleCount'           => $femaleCount,
            'educationCounts'       => $educationCounts,
            'absentCount'           => $absentCount,
            'absentNames'           => $absentNames,
            'accidentCount'         => $accidentCount,
            'accidentNames'         => $accidentNames,
            'escapeCount'           => $escapeCount,
            'escapeNames'           => $escapeNames,
            'today'                 => $today,
            'educations'            => $educations,
            'problems'              => $problems,
            'startMonth'            => $startMonth ?? '',
            'startYear'             => $startYear ?? '',
            'endMonth'              => $endMonth ?? '',
            'endYear'               => $endYear ?? '',
            'appointments'          => $appointments,
            'appointmentCount'      => $appointmentCount,
            'pendingReferApprovals' => $pendingReferApprovals,
            'latestCaseActivities'  => $latestCaseActivities,
        ]);
    }
}