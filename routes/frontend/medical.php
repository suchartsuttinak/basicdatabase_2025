<?php

use App\Http\Controllers\Frontend\MedicalController;
use Illuminate\Support\Facades\Route;

// Medical Modal Route All
Route::prefix('medical')->name('medical.')->group(function () {
    // แสดงรายการข้อมูลการรักษาของ client
    Route::get('/add/{client_id}', [MedicalController::class, 'MedicalAdd'])->name('add');

    // หน้ารายงานการรักษา
    Route::get('/report/{client_id}', [MedicalController::class, 'MedicalReport'])->name('report');

    // บันทึกข้อมูลใหม่
    Route::post('/store', [MedicalController::class, 'MedicalStore'])->name('store');

    // อัปเดตข้อมูล
    Route::put('/update/{id}', [MedicalController::class, 'MedicalUpdate'])->name('update');

    // ลบข้อมูล
    Route::delete('/delete/{id}', [MedicalController::class, 'MedicalDelete'])->name('delete');

    // โหลดข้อมูล JSON สำหรับ modal edit
    Route::get('/json/{id}', [MedicalController::class, 'editMedicalJson'])->name('json');
});