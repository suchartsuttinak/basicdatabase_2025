<?php


use App\Http\Controllers\Frontend\CaseOutsideController;
use Illuminate\Support\Facades\Route;


// Routes ติดตามเด็กที่อยู่นอกสถานสงเคราะห์ (CaseOutside)
    Route::prefix('case-outside')->group(function(){
    Route::get('/show/{client_id}', [CaseOutsideController::class, 'ShowCaseOutside'])->name('case_outside.show');
    Route::post('/store', [CaseOutsideController::class, 'StoreCaseOutside'])->name('case_outside.store');
    Route::put('/update/{id}', [CaseOutsideController::class, 'UpdateCaseOutside'])->name('case_outside.update');
    Route::delete('/delete/{id}', [CaseOutsideController::class, 'DeleteCaseOutside'])->name('case_outside.delete');
});