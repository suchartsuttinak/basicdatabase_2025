<?php


use App\Http\Controllers\Frontend\MedicalController;
use Illuminate\Support\Facades\Route;

// 🏫 บันทึกการรักษาพยาบาลในหน่วยงาน
Route::prefix('medical')->name('medical.')->group(function () {
    // ✅ แสดงฟอร์มเพิ่มข้อมูลใหม่ (client_id จำเป็น)
    Route::get('/add/{client_id}', [MedicalController::class, 'MedicalAdd'])->name('add');

    // ✅ บันทึกข้อมูลใหม่
    Route::post('/store', [MedicalController::class, 'MedicalStore'])->name('store');

    // ❌ ตัดออก: ไม่ต้องใช้ MedicalEdit แล้ว
    // Route::get('/edit/{id}', [MedicalController::class, 'MedicalEdit'])->name('edit');

    // ✅ อัปเดตข้อมูล (PUT)
    Route::put('/update/{id}', [MedicalController::class, 'MedicalUpdate'])->name('update');

    // ✅ ลบข้อมูล
    Route::delete('/delete/{id}', [MedicalController::class, 'MedicalDelete'])->name('delete');

    // ✅ รายงาน
    Route::get('/report/{id}', [MedicalController::class, 'MedicalReport'])->name('report');

    // ✅ โหลดข้อมูล JSON สำหรับ modal edit
    Route::get('/json/{id}', [MedicalController::class, 'editMedicalJson'])->name('json');
});
