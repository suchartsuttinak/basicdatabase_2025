<?php

use App\Http\Controllers\Frontend\AddictiveController;
use Illuminate\Support\Facades\Route;

Route::prefix('addictive')->group(function () {
    Route::get('/add/{client_id}', [AddictiveController::class, 'AddAddictive'])->name('addictive.create');
    Route::post('/store', [AddictiveController::class, 'StoreAddictive'])->name('addictive.store');
    Route::get('/edit/{id}', [AddictiveController::class, 'EditAddictive'])->name('addictive.edit');
    Route::put('/update/{id}', [AddictiveController::class, 'UpdateAddictive'])->name('addictive.update');
    Route::delete('/delete/{id}', [AddictiveController::class, 'DeleteAddictive'])->name('addictive.delete');
    Route::get('/json/{id}', [AddictiveController::class, 'EditAddictiveJson'])->name('addictive.json');

    // รายงานรายครั้ง
    Route::get('/report/{id}', [AddictiveController::class, 'ReportAddictive'])->name('addictive.report');

    // รายงานทั้งหมด + filter ช่วงวันที่
    Route::get('/report-all/{client_id}', [AddictiveController::class, 'ReportAddictiveAll'])->name('addictive.report.all');
});