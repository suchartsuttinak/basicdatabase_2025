<?php


use App\Http\Controllers\Landing\ScholarshipChildController;
use Illuminate\Support\Facades\Route;

 // Scholarship Children
        Route::middleware(['auth'])->group(function () {
        Route::prefix('scholarship/children')->name('scholarship.children.')->group(function () {
        Route::get('/', [ScholarshipChildController::class, 'index'])->name('index');
        Route::post('/store', [ScholarshipChildController::class, 'store'])->name('store');
        Route::put('/update/{id}', [ScholarshipChildController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ScholarshipChildController::class, 'destroy'])->name('delete');
        Route::get('/report', [ScholarshipChildController::class, 'report'])->name('report');
    });
});