<?php

use App\Http\Controllers\Frontend\AbsentController;
use Illuminate\Support\Facades\Route;

Route::prefix('absent')->name('absent.')->group(function () {
    Route::get('/add/{client_id}', [AbsentController::class, 'AbsentAdd'])->name('add');
    Route::post('/store', [AbsentController::class, 'AbsentStore'])->name('store');
    Route::get('/edit/{id}', [AbsentController::class, 'AbsentEdit'])->name('edit');
    Route::get('/edit-view/{id}', [AbsentController::class, 'AbsentEditView'])->name('edit.view');
    Route::put('/update/{id}', [AbsentController::class, 'AbsentUpdate'])->name('update');
    Route::delete('/delete/{id}', [AbsentController::class, 'AbsentDelete'])->name('delete');
    Route::get('/report/{id}', [AbsentController::class, 'AbsentReport'])->name('report');

    // ✅ เพิ่มรายงานรวม + filter ช่วงวันที่
    Route::get('/report-range/{client_id}', [AbsentController::class, 'AbsentReportRange'])->name('report.range');
});