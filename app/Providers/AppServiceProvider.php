<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Refer;
use App\Models\Absent;
use App\Models\Medical;
use App\Models\Psychiatric;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
{
    View::composer('admin.body.header', function ($view) {
        $today = Carbon::today();

        $pendingRefers = 0;
        $todayAbsents = 0;
        $todayIllnesses = 0;
        $upcomingAppointments = 0;
        $overdueAppointments = 0;

        $pendingReferItems = collect();
        $todayAbsentItems = collect();
        $todayIllnessItems = collect();
        $upcomingAppointmentItems = collect();

        if (auth()->check()) {
            $authorizedClientIds = Client::forUser(auth()->user())->pluck('id');

            if (class_exists(Refer::class) && Schema::hasTable('refers')) {
                    $pendingReferItems = Refer::with('client')
                        ->where('approve_status', 'pending')
                        ->whereIn('client_id', $authorizedClientIds)
                        ->whereHas('client', function ($query) {
                            $query->where('release_status', 'pending_refer');
                        })
                        ->latest()
                        ->limit(10)
                        ->get();

                    $pendingRefers = $pendingReferItems->count();
                }

            if (class_exists(Absent::class) && Schema::hasTable('absents') && Schema::hasColumn('absents', 'absent_date')) {
                $todayAbsentItems = Absent::with('client')
                    ->whereDate('absent_date', $today)
                    ->whereIn('client_id', $authorizedClientIds)
                    ->latest()
                    ->limit(10)
                    ->get();

                $todayAbsents = $todayAbsentItems->count();
            }

            if (class_exists(Medical::class) && Schema::hasTable('medicals') && Schema::hasColumn('medicals', 'medical_date')) {
                $todayIllnessItems = Medical::with('client')
                    ->whereDate('medical_date', $today)
                    ->whereIn('client_id', $authorizedClientIds)
                    ->latest()
                    ->limit(10)
                    ->get();

                $todayIllnesses = $todayIllnessItems->count();
            }

            if (class_exists(Medical::class) && Schema::hasTable('medicals') && Schema::hasColumn('medicals', 'appointment_date')) {
                $medicalUpcomingItems = Medical::with('client')
                    ->whereDate('appointment_date', '>=', $today)
                    ->whereDate('appointment_date', '<=', $today->copy()->addDays(7))
                    ->whereIn('client_id', $authorizedClientIds)
                    ->orderBy('appointment_date')
                    ->limit(10)
                    ->get();

                $upcomingAppointmentItems = $upcomingAppointmentItems->merge($medicalUpcomingItems);
            }

            if (class_exists(Psychiatric::class) && Schema::hasTable('psychiatrics') && Schema::hasColumn('psychiatrics', 'appoin_date')) {
                $psychiatricUpcomingItems = Psychiatric::with('client')
                    ->whereDate('appoin_date', '>=', $today)
                    ->whereDate('appoin_date', '<=', $today->copy()->addDays(7))
                    ->whereIn('client_id', $authorizedClientIds)
                    ->orderBy('appoin_date')
                    ->limit(10)
                    ->get();

                $upcomingAppointmentItems = $upcomingAppointmentItems->merge($psychiatricUpcomingItems);
            }

            // เรียงนัดพบแพทย์ทั้งหมด ทั้ง Medical และ Psychiatric ให้วันที่ใกล้สุดอยู่บนสุด
            $upcomingAppointmentItems = $upcomingAppointmentItems
                ->sortBy(function ($item) {
                    return $item->appointment_date ?? $item->appoin_date ?? null;
                })
                ->values();

            $upcomingAppointments = $upcomingAppointmentItems->count();
        }

        $notificationCount =
            $pendingRefers
            + $todayAbsents
            + $todayIllnesses
            + $upcomingAppointments;

        $view->with(compact(
            'pendingRefers',
            'todayAbsents',
            'todayIllnesses',
            'upcomingAppointments',
            'overdueAppointments',
            'notificationCount',
            'pendingReferItems',
            'todayAbsentItems',
            'todayIllnessItems',
            'upcomingAppointmentItems'
        ));
    });
}
}