<?php

use App\Http\Controllers\Frontend\AbsentController;
use Illuminate\Support\Facades\Route;

 Route::prefix('absent')->name('absent.')->group(function () {
    Route::get('/add/{client_id}', [AbsentController::class, 'AbsentAdd'])->name('add');
    Route::post('/store', [AbsentController::class, 'AbsentStore'])->name('store');
    Route::get('/edit/{id}', [AbsentController::class, 'AbsentEdit'])->name('edit'); // ✅ JSON สำหรับ AJAX
    Route::get('/edit-view/{id}', [AbsentController::class, 'AbsentEditView'])->name('edit.view'); // ✅ View
    // ✅ Update รองรับทั้ง AJAX และ redirect
    Route::put('/update/{id}', [AbsentController::class, 'AbsentUpdate'])->name('update');
    Route::delete('/delete/{id}', [AbsentController::class, 'AbsentDelete'])->name('delete');
    Route::get('/report/{id}', [AbsentController::class, 'AbsentReport'])->name('report');
});


