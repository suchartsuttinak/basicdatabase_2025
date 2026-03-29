<?php


use App\Http\Controllers\Frontend\CheckBodyController;
use Illuminate\Support\Facades\Route;


// 🏫 ตรวจสุขภาพเบื้องต้น
    Route::prefix('check_body')->name('check_body.')->group(function () {
    Route::get('/add/{client_id}', [CheckBodyController::class, 'CheckBodyAdd'])->name('add');
    Route::post('/store', [CheckBodyController::class, 'CheckBodyStore'])->name('store');
    Route::get('/edit/{id}', [CheckBodyController::class, 'CheckBodyEdit'])->name('edit');
    Route::put('/update/{id}', [CheckBodyController::class, 'CheckBodyUpdate'])->name('update');
    Route::delete('/delete/{id}', [CheckBodyController::class, 'CheckBodyDelete'])->name('delete');
    Route::get('/report/{id}', [CheckBodyController::class, 'CheckBodyReport'])->name('report');
});