<?php

use App\Http\Controllers\Frontend\VisitFamilyController;
use Illuminate\Support\Facades\Route;

// Vitsit_Family Route All
    Route::prefix('vitsitFamily')->group(function () {
    Route::get('/add/{client_id}', [VisitFamilyController::class, 'AddvisitFamily'])->name('visitFamily.create');
    Route::post('/store/{client_id}', [VisitFamilyController::class, 'StoreVisitFamily'])->name('vitsitFamily.store');
    Route::get('/edit/{id}', [VisitFamilyController::class, 'EditVisitFamily'])->name('vitsitFamily.edit');
    Route::put('/update/{id}', [VisitFamilyController::class, 'UpdateVisitFamily'])->name('vitsitFamily.update');
  
    // (ตัวเลือก) ถ้าจะทำ “แทนที่รูป” ให้เพิ่ม route นี้
    Route::patch('/image/{id}', [VisitFamilyController::class, 'replaceImage'])->name('image.replace');

    // ชี้ไปที่ VisitFamilyController@destroy ให้ตรงกับเมธอดที่มีอยู่
     Route::delete('/vitsitFamily/image/{id}', [VisitFamilyController::class, 'destroy'])
        ->name('image.destroy');

    // Ajax Route จังหวัด-อำเภอ-ตำบล-รหัสไปรษณีย์
    Route::get('/get-districts/{province_id}', [VisitFamilyController::class, 'getDistricts'])
        ->name('vitsitFamily.getDistricts');

    Route::get('/get-subdistricts/{district_id}', [VisitFamilyController::class, 'getSubdistricts'])
        ->name('vitsitFamily.getSubdistricts');

    Route::get('/get-zipcode/{subdistrict_id}', [VisitFamilyController::class, 'getZipcode'])
        ->name('vitsitFamily.getZipcode');
});