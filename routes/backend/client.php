<?php

use App\Http\Controllers\backend\ClientController;
use Illuminate\Support\Facades\Route;


// Client Route All
    Route::middleware('auth')->group(function () {
    Route::get('/client', [ClientController::class, 'clientShow'])->name('client.show');
    Route::get('/client/refer', [ClientController::class, 'clientShowRefer'])->name('client.show_refer');
    Route::get('/client/add', [ClientController::class, 'clientAdd'])->name('client.add');
    Route::post('/client/store', [ClientController::class, 'ClientStore'])->name('client.store');
    Route::get('/client/edit/{id}', [ClientController::class, 'ClientEdit'])->name('client.edit');
    Route::post('/client/update', [ClientController::class, 'ClientUpdate'])->name('client.update');
    Route::get('/client/delete/{id}', [ClientController::class, 'ClientDelete'])->name('client.delete');

    // ✅ เพิ่ม route สำหรับเปลี่ยนสถานะ client จาก refer → show
    Route::post('/client/change-status/{id}', [ClientController::class, 'changeStatus'])
     ->name('client.changeStatus');


    
// Ajax Route All จังหวัด-อําเภอ-ตําบล
    Route::get('/get-districts/{province_id}', [ClientController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district_id}', [ClientController::class, 'getSubdistricts']);
    Route::get('/get-zipcode/{subdistrict_id}', [ClientController::class, 'getZipcode']); 

     // ✅ Ajax Route All จังหวัด-อำเภอ-ตำบล (ภูมิลำเนาเดิม)
    Route::get('/get-origin-districts/{province_id}', [ClientController::class, 'getOriginDistricts']);
    Route::get('/get-origin-subdistricts/{district_id}', [ClientController::class, 'getOriginSubdistricts']);
    Route::get('/get-origin-zipcode/{subdistrict_id}', [ClientController::class, 'getOriginZipcode']);
});
