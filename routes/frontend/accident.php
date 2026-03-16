<?php

use App\Http\Controllers\Frontend\AccidentController;
use Illuminate\Support\Facades\Route;


// 🏫 บันทึกการบาดเจ็บของเด็ก
    Route::prefix('accident')->name('accident.')->group(function () {
    // แสดงฟอร์มเพิ่มข้อมูล (client_id จำเป็น)
    Route::get('/add/{client_id}', [AccidentController::class, 'AccidentAdd'])->name('add');

    // บันทึกข้อมูลใหม่
    Route::post('/store', [AccidentController::class, 'AccidentStore'])->name('store');

    // ใช้ฟอร์มเดิมในการแก้ไข (ส่ง accident id)
    Route::get('/edit/{id}', [AccidentController::class, 'AccidentEdit'])->name('edit');

    // อัปเดตข้อมูล (PUT)
    Route::put('/update/{id}', [AccidentController::class, 'AccidentUpdate'])->name('update');

    // ลบข้อมูล
    Route::delete('/delete/{id}', [AccidentController::class, 'AccidentDelete'])->name('delete');

    // ✅ เพิ่ม route สำหรับรายงาน (ตรงกับปุ่มใน view)
    Route::get('/report/{id}', [AccidentController::class, 'AccidentReport'])->name('report');
});
