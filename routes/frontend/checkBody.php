<?php


use App\Http\Controllers\Frontend\CheckBodyController;
use Illuminate\Support\Facades\Route;


// 🏫 ตรวจสุขภาพเบื้องต้น
    Route::prefix('check_body')->name('check_body.')->group(function () {
    // แสดงฟอร์มเพิ่มข้อมูล (client_id จำเป็น)
    Route::get('/add/{client_id}', [CheckBodyController::class, 'CheckBodyAdd'])->name('add');
     // บันทึกข้อมูลใหม่
    Route::post('/store', [CheckBodyController::class, 'CheckBodyStore'])->name('store');

    // ใช้ฟอร์มเดิมในการแก้ไข (ส่ง accident id)
    Route::get('/edit/{id}', [CheckBodyController::class, 'CheckBodyEdit'])->name('edit');

    // อัปเดตข้อมูล (PUT)
    Route::put('/update/{id}', [CheckBodyController::class, 'CheckBodyUpdate'])->name('update');

    // ลบข้อมูล
    Route::delete('/delete/{id}', [CheckBodyController::class, 'CheckBodyDelete'])->name('delete');

    // ✅ เพิ่ม route สำหรับรายงาน (ตรงกับปุ่มใน view)
    Route::get('/report/{id}', [CheckBodyController::class, 'CheckBodyReport'])->name('report');
});