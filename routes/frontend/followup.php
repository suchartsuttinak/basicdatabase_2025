<?php

use App\Http\Controllers\Frontend\FollowupController;
use Illuminate\Support\Facades\Route;

    Route::middleware('auth')->group(function () {
    Route::get('/followup/{client_id}', [FollowupController::class, 'index'])
        ->whereNumber('client_id')
        ->name('followup.index');

    Route::post('/followup/store/{client_id}', [FollowupController::class, 'store'])
        ->whereNumber('client_id')
        ->name('followup.store');

    Route::post('/followup/update/{id}', [FollowupController::class, 'update'])
        ->whereNumber('id')
        ->name('followup.update');

    Route::post('/followup/delete/{id}', [FollowupController::class, 'destroy'])
        ->whereNumber('id')
        ->name('followup.delete');

    // ===== รายงานรวมทั้งผู้รับบริการ =====
    Route::get('/followup/report/{client_id}', [FollowupController::class, 'report'])
        ->whereNumber('client_id')
        ->name('followup.report');

    Route::get('/followup/pdf/{client_id}', [FollowupController::class, 'exportPdf'])
        ->whereNumber('client_id')
        ->name('followup.pdf');

    // ===== รายงานเฉพาะ 1 รายการ =====
    Route::get('/followup/report-item/{id}', [FollowupController::class, 'reportItem'])
        ->whereNumber('id')
        ->name('followup.report_item');
});