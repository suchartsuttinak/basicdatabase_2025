<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Absent;
use App\Models\Accident;
use App\Models\Escape;
use App\Models\Education;
use App\Models\Problem;
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
        $problemId     = $request->input('problem', null); // ✅ เพิ่ม filter สภาพปัญหา

        // preload educationRecords และกรอง educationRecords ให้ตรงกับ filter
        $query = Client::with(['educationRecords' => function($q) use ($education, $institutionId) {
            if ($education) {
                $q->where('education_id', $education);
            }
            if ($institutionId) {
                $q->where('institution_id', $institutionId);
            }
            $q->with(['education','semester','institution']);
        }, 'problems']); // ✅ preload ความสัมพันธ์ problems ด้วย

        // กรองตามช่วงปี พ.ศ.
        if ($yearMin && $yearMax) {
            $query->whereBetween('created_at', [
                ($yearMin - 543).'-01-01',
                ($yearMax - 543).'-12-31'
            ]);
        }

        // กรองตามเดือน
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
            $query->whereHas('educationRecords', function($q) use ($education) {
                $q->where('education_id', $education);
            });
        }
        if ($institutionId) {
            $query->whereHas('educationRecords', function($q) use ($institutionId) {
                $q->where('institution_id', $institutionId);
            });
        }

        // ✅ กรองตามสภาพปัญหา
        if ($problemId) {
            $query->whereHas('problems', function($q) use ($problemId) {
                $q->where('problems.id', $problemId);
            });
        }

        // release_status (ไม่กรองถ้าเลือก "all")
        if (!empty($releaseStatus) && $releaseStatus !== 'all') {
            $query->whereIn('release_status', (array) $releaseStatus);
        }

        $clients = $query->get();

        $maleCount   = $clients->where('gender', 'male')->count();
        $femaleCount = $clients->where('gender', 'female')->count();

        // นับจำนวนตามระดับการศึกษา
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

        // ✅ ตรวจสอบเฉพาะ "วันปัจจุบัน" เท่านั้น
        $today = Carbon::today()->toDateString();

        // การขาดเรียน
        $absentRecords = Absent::with('client')
            ->whereDate('absent_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();
        $absentCount = $absentRecords->count();
        $absentNames = $absentRecords->map(fn($record) => $record->client->fullname)->toArray();

        // การเจ็บป่วย
        $accidentRecords = Accident::with('client')
            ->whereDate('incident_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();
        $accidentCount = $accidentRecords->count();
        $accidentNames = $accidentRecords->map(fn($record) => $record->client->fullname)->toArray();

        // การออกโดยไม่ได้รับอนุญาต
        $escapeRecords = Escape::with('client')
            ->whereDate('retire_date', $today)
            ->groupBy('client_id')
            ->selectRaw('MIN(id) as id, client_id')
            ->get();
        $escapeCount = $escapeRecords->count();
        $escapeNames = $escapeRecords->map(fn($record) => $record->client->fullname)->toArray();

        // ✅ ดึงข้อมูล dropdown filter
        $educations = Education::all();
        $problems   = Problem::all();

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
            'problem'          => $problemId ?? '', // ✅ ส่งค่า problem ไปด้วย
            'maleCount'        => $maleCount,
            'femaleCount'      => $femaleCount,
            'educationCounts'  => $educationCounts,
            'absentCount'      => $absentCount,
            'absentNames'      => $absentNames,
            'accidentCount'    => $accidentCount,
            'accidentNames'    => $accidentNames,
            'escapeCount'      => $escapeCount,
            'escapeNames'      => $escapeNames,
            'today'            => $today,
            'educations'       => $educations,
            'problems'         => $problems,
        ]);
    }
}