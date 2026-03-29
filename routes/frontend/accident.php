<?php

use App\Http\Controllers\Frontend\AccidentController;
use Illuminate\Support\Facades\Route;


Route::prefix('accident')->name('accident.')->group(function () {
    Route::get('/add/{client_id}', [AccidentController::class, 'AccidentAdd'])->name('add');
    Route::post('/store', [AccidentController::class, 'AccidentStore'])->name('store');
    Route::get('/edit/{id}', [AccidentController::class, 'AccidentEdit'])->name('edit');
    Route::put('/update/{id}', [AccidentController::class, 'AccidentUpdate'])->name('update');
    Route::delete('/delete/{id}', [AccidentController::class, 'AccidentDelete'])->name('delete');
    Route::get('/report/{id}', [AccidentController::class, 'AccidentReport'])->name('report');
});