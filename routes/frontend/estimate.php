<?php

use App\Http\Controllers\Frontend\EstimateController;
use Illuminate\Support\Facades\Route;


 // Routes ประเมินครอบครัว (Estimate)
   Route::prefix('estimate')->group(function(){
    Route::get('/show/{client_id}', [EstimateController::class, 'ShowEstimate'])->name('estimate.show');
    Route::post('/store', [EstimateController::class, 'StoreEstimate'])->name('estimate.store');
    Route::get('/edit/{id}', [EstimateController::class, 'EditEstimate'])->name('estimate.edit');
    Route::put('/update/{id}', [EstimateController::class, 'UpdateEstimate'])->name('estimate.update');
    Route::delete('/delete/{id}', [EstimateController::class, 'DeleteEstimate'])->name('estimate.delete');
    Route::get('/estimate/check-duplicate', [EstimateController::class, 'CheckDuplicate']);
});