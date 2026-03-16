<?php


use App\Http\Controllers\Frontend\VaccinationController;
use Illuminate\Support\Facades\Route;


// Vaccination Modal Route All
    Route::prefix('vaccine')->name('vaccine.')->group(function () {
    // แสดงรายการวัคซีนของ client
    Route::get('/add/{client_id}', [VaccinationController::class, 'VaccineShow'])->name('index');

    // บันทึกข้อมูลวัคซีนใหม่
    Route::post('/store', [VaccinationController::class, 'VaccineStore'])->name('store');

    // ดึงข้อมูลวัคซีนมาแก้ไข (ใช้กับ AJAX Modal)
    Route::get('/edit/{id}', [VaccinationController::class, 'VaccineEdit'])->name('edit');

    // อัปเดตข้อมูลวัคซีน (ต้องใช้ PUT)
    Route::put('/update/{id}', [VaccinationController::class, 'VaccineUpdate'])->name('update');

    // ลบข้อมูลวัคซีน (ต้องใช้ DELETE)
    Route::delete('/delete/{id}', [VaccinationController::class, 'VaccineDelete'])->name('delete');
});
