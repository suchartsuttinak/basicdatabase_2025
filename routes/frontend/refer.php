<?php

use App\Http\Controllers\Frontend\ReferController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('refer')->group(function () {
    // ✅ ตารางการจำหน่ายรวม สำหรับ admin / executive
    Route::get('/refers/all', [ReferController::class, 'allRefers'])->name('refers.all');

    // ✅ รายงานราย client
    Route::get('/refers/report/{client_id}', [ReferController::class, 'report'])->name('refers.report');

    // ✅ หน้า refer ราย client
    Route::get('/refers/{client_id}', [ReferController::class, 'index'])->name('refers.index');

    Route::post('/refers/store', [ReferController::class, 'store'])->name('refers.store');

    // อนุมัติการจำหน่าย
    Route::put('/refers/{id}/approve', [ReferController::class, 'approve'])->name('refers.approve');

    // คืนสถานะ
    Route::put('/refers/{id}/restore', [ReferController::class, 'restore'])->name('refers.restore');
});