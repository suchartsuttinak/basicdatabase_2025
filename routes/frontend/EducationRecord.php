<?php


use App\Http\Controllers\Frontend\EducationRecordController;
use Illuminate\Support\Facades\Route;


// Education Record Route All
    Route::middleware('auth')->group(function () {
    // เปิดฟอร์ม (GET)
    Route::get('/education_record/add/{client_id}', 
        [EducationRecordController::class, 'EducationRecordAdd']
    )->name('education_record.add');  

    // บันทึกข้อมูล (POST)
    Route::post('/education_record/store', [EducationRecordController::class, 'EducationRecordStore']
        )->name('education_record.store');  

    // แสดงข้อมูลการศึกษา (GET)
    Route::get('/education_record/show/{client_id}', 
        [EducationRecordController::class, 'EducationRecordShow']
        )->name('education_record_show');

    // แก้ไขข้อมูลการศึกษา (GET)
    Route::get('/education_record/edit/{id}', 
        [EducationRecordController::class, 'EducationRecordEdit']
        )->name('education_record.edit');

    // บันทึกข้อมูลการศึกษา (POST)
    Route::post('/education_record/update/{id}', 
        [EducationRecordController::class, 'EducationRecordUpdate']
        )->name('education_record_update');
});

    // 📚 บันทึกผลการเรียน
    Route::prefix('education-record')->group(function () {
        Route::get('/add/{client_id}', 
            [EducationRecordController::class, 'EducationRecordAdd']
        )->name('education_record_add');

        Route::post('/store', 
            [EducationRecordController::class, 'EducationRecordStore']
        )->name('education_record_store');

        Route::get('/{client_id}', 
            [EducationRecordController::class, 'EducationRecordShow']
        )->name('education_record_show');

        Route::get('/edit/{id}', 
            [EducationRecordController::class, 'EducationRecordEdit']
        )->name('education_record_edit');

        Route::put('/update/{id}', 
            [EducationRecordController::class, 'EducationRecordUpdate']
        )->name('education_record_update');

        Route::delete('/delete/{id}', 
            [EducationRecordController::class, 'EducationRecordDelete']
        )->name('education_record_delete');
    });