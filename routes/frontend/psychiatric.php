<?php

use App\Http\Controllers\Frontend\PsychiatricController;
use Illuminate\Support\Facades\Route;

// บันทึกการตรวจวินิจฉัยทางจิตเวช Psychiatric
Route::prefix('psychiatric')->group(function () {
    // เพิ่มข้อมูลใหม่
    Route::get('/add/{client_id}', [PsychiatricController::class, 'AddPsychiatric'])
        ->name('psychiatric.create');

    // บันทึกข้อมูลใหม่
    Route::post('/store', [PsychiatricController::class, 'StorePsychiatric'])
        ->name('psychiatric.store');

    // ✅ รายงาน
    Route::get('/report/{client_id}', [PsychiatricController::class, 'ReportPsychiatric'])
        ->name('psychiatric.report');

    // สำหรับเรียกข้อมูลมาแก้ไข (JSON)
    Route::get('/edit-json/{id}', [PsychiatricController::class, 'EditPsychiatricJson'])
        ->name('psychiatric.edit.json');

    // สำหรับอัปเดตข้อมูล (PUT)
    Route::put('/{id}', [PsychiatricController::class, 'UpdatePsychiatric'])
        ->name('psychiatric.update');

    // ลบข้อมูล
    Route::delete('/delete/{id}', [PsychiatricController::class, 'DeletePsychiatric'])
        ->name('psychiatric.delete');
});