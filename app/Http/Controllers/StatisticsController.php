<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

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
    $releaseStatus = $request->input('release_status', []); // รองรับ array เช่น ['show','refer']

     // ✅ ถ้าไม่ได้ส่งค่า release_status มา ให้ default เป็น "show"
    $releaseStatus = $request->input('release_status', 'show');

    // preload educationRecords และกรอง educationRecords ให้ตรงกับ filter
    $query = Client::with(['educationRecords' => function($q) use ($education, $institutionId) {
        if ($education) {
            $q->where('education_id', $education);
        }
        if ($institutionId) {
            $q->where('institution_id', $institutionId);
        }
        $q->with(['education','semester','institution']);
    }]);

    // ✅ กรองตามช่วงปี พ.ศ.
    if ($yearMin && $yearMax) {
        $query->whereBetween('created_at', [
            ($yearMin - 543).'-01-01',
            ($yearMax - 543).'-12-31'
        ]);
    }

    // ✅ กรองตามเดือน
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

    // ✅ release_status (ไม่กรองถ้าเลือก "all")
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
        'maleCount'        => $maleCount,
        'femaleCount'      => $femaleCount,
        'educationCounts'  => $educationCounts,
    ]);
}
}