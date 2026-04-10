<?php

use App\Http\Controllers\backend\ClientController;
use Illuminate\Support\Facades\Route;

// Client Route All
Route::middleware('auth')->group(function () {

    // ===== ดูข้อมูลได้ตามปกติ =====
    Route::get('/client', [ClientController::class, 'clientShow'])->name('client.show');
    Route::get('/client/refer', [ClientController::class, 'clientShowRefer'])->name('client.show_refer');

    Route::get('/get-districts/{province_id}', [ClientController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district_id}', [ClientController::class, 'getSubdistricts']);
    Route::get('/get-zipcode/{subdistrict_id}', [ClientController::class, 'getZipcode']);

    Route::get('/get-origin-districts/{province_id}', [ClientController::class, 'getOriginDistricts']);
    Route::get('/get-origin-subdistricts/{district_id}', [ClientController::class, 'getOriginSubdistricts']);
    Route::get('/get-origin-zipcode/{subdistrict_id}', [ClientController::class, 'getOriginZipcode']);

    // ===== เพิ่ม / บันทึก / แก้ไข / อัปเดต =====
    Route::middleware('role:admin,executive,social_worker')->group(function () {
        Route::get('/client/add', [ClientController::class, 'clientAdd'])->name('client.add');
        Route::post('/client/store', [ClientController::class, 'ClientStore'])->name('client.store');
        Route::get('/client/edit/{id}', [ClientController::class, 'ClientEdit'])->name('client.edit');
        Route::post('/client/update', [ClientController::class, 'ClientUpdate'])->name('client.update');

        // ถ้าต้องการให้เปลี่ยนสถานะได้ 3 สิทธิ์นี้ คงไว้ตรงนี้
        Route::post('/client/change-status/{id}', [ClientController::class, 'changeStatus'])
            ->name('client.changeStatus');
    });

    // ===== ลบได้เฉพาะ admin เท่านั้น =====
    Route::middleware('role:admin')->group(function () {
        Route::get('/client/delete/{id}', [ClientController::class, 'ClientDelete'])->name('client.delete');
    });
});