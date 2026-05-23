<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CaseActivity;
use App\Models\Client;
use Illuminate\Http\Request;

class CaseActivityController extends Controller
{
    public function index(Request $request, $client)
    {
        $client = Client::findOrFail($client);

        $this->ensureInitialActivity($client);

        $query = CaseActivity::with('user')
            ->where('client_id', $client->id)
            ->latest('occurred_at')
            ->latest('id');

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('occurred_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('occurred_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(20)->withQueryString();

        $modules = CaseActivity::where('client_id', $client->id)
            ->whereNotNull('module')
            ->select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        return view('frontend.case_activities.index', compact(
            'client',
            'activities',
            'modules'
        ));
    }

    public function report(Request $request, $client)
    {
        $client = Client::findOrFail($client);

        $this->ensureInitialActivity($client);

        $query = CaseActivity::with('user')
            ->where('client_id', $client->id)
            ->latest('occurred_at')
            ->latest('id');

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('occurred_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('occurred_at', '<=', $request->date_to);
        }

        $activities = $query->get();

        return view('frontend.case_activities.report', compact(
            'client',
            'activities'
        ));
    }

    private function ensureInitialActivity(Client $client): void
    {
        $exists = CaseActivity::where('client_id', $client->id)
            ->where('module', 'client')
            ->where('title', 'บันทึกข้อมูลแรกเข้า')
            ->exists();

        if ($exists) {
            return;
        }

        CaseActivity::create([
            'client_id'   => $client->id,
            'user_id'     => auth()->id(),
            'module'      => 'client',
            'type'        => 'success',
            'title'       => 'บันทึกข้อมูลแรกเข้า',
            'description' => 'มีการสร้างแฟ้มทะเบียนประวัติผู้รับบริการเข้าสู่ระบบ',
            'occurred_at' => $client->created_at ?? now(),
            'icon'        => 'bi-person-plus',
            'url'         => route('client.edit', $client->id),
        ]);
    }
}