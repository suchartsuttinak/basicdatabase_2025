<?php


use App\Http\Controllers\Frontend\FamilyController;
use Illuminate\Support\Facades\Route;


  // Family Route All
    Route::middleware('auth')->group(function () {
    Route::get('/family/add/{client_id}', [FamilyController::class, 'FamilyAdd'])->name('family.add'); 
    Route::post('/family/store', [FamilyController::class, 'FamilyStore'])->name('family.store');
   
   // Ajax Route All จังหวัด-อำเภอ-ตำบล
    Route::get('/get-districts/{province_id}', [FamilyController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district_id}', [FamilyController::class, 'getSubdistricts']);
    Route::get('/get-zipcode/{subdistrict_id}', [FamilyController::class, 'getZipcode']);

});
