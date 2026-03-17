<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class StatisticsController extends Controller
{
    public function index(Request $request)
{
    $year      = $request->input('year', null);
    $gender    = $request->input('gender', null);
    $ageMin    = $request->input('age_min', 1);
    $ageMax    = $request->input('age_max', 99);
    $education = $request->input('education', null);

    // ✅ preload educationRecords และกรอง educationRecords ให้ตรงกับ filter
    $query = Client::with(['educationRecords' => function($q) use ($education) {
        if ($education) {
            $q->where('education_id', $education);
        }
        $q->with(['education','semester','institution']);
    }]);

    if ($year) {
        $query->whereYear('created_at', $year - 543);
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

    $clients = $query->get();

    $maleCount   = $clients->where('gender', 'male')->count();
    $femaleCount = $clients->where('gender', 'female')->count();

    // ✅ นับจำนวนตามระดับการศึกษา
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
        'year'             => $year ?? '',
        'gender'           => $gender ?? '',
        'ageMin'           => $ageMin ?? '',
        'ageMax'           => $ageMax ?? '',
        'education'        => $education ?? '',
        'maleCount'        => $maleCount,
        'femaleCount'      => $femaleCount,
        'educationCounts'  => $educationCounts, // ✅ ส่งไป View
    ]);
}
}