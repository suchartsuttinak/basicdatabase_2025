<?php

use App\Http\Controllers\Frontend\ReferController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin,executive,social_worker'])
    ->prefix('refer')
    ->group(function () {

        // ✅ ตารางการจำหน่ายรวม
        Route::get('/refers/all', [ReferController::class, 'allRefers'])
            ->name('refers.all');

        // ✅ รายงานราย client
        Route::get('/refers/report/{client_id}', [ReferController::class, 'report'])
            ->name('refers.report');

        // ✅ หน้า refer ราย client
        Route::get('/refers/{client_id}', [ReferController::class, 'index'])
            ->name('refers.index');

        // ✅ บันทึกการจำหน่าย
        Route::post('/refers/store', [ReferController::class, 'store'])
            ->name('refers.store');

        // ✅ อนุมัติการจำหน่าย
        // คงสิทธิ์เดิมใน Controller: admin / executive เท่านั้น
        Route::put('/refers/{id}/approve', [ReferController::class, 'approve'])
            ->name('refers.approve');

        // ✅ คืนสถานะ
        // คงสิทธิ์เดิมใน Controller: admin / executive เท่านั้น
        Route::put('/refers/{id}/restore', [ReferController::class, 'restore'])
            ->name('refers.restore');
    });