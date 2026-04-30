<?php

use App\Http\Controllers\Frontend\ClientFileController;
use Illuminate\Support\Facades\Route;

    Route::prefix('clients/{client_id}')->group(function () {

    Route::get('files', [ClientFileController::class, 'index'])
        ->name('client_files.index');

    Route::get('files/create', [ClientFileController::class, 'create'])
        ->name('client_files.create');

    Route::post('files', [ClientFileController::class, 'store'])
        ->name('client_files.store');

    Route::delete('files/{file}', [ClientFileController::class, 'destroy'])
        ->name('client_files.destroy');

    // ✅ เพิ่ม 2 route นี้ (สำคัญมาก)
    Route::get('files/{file}/view', [ClientFileController::class, 'view'])
        ->name('client_files.view');

    Route::get('files/{file}/download', [ClientFileController::class, 'download'])
        ->name('client_files.download');

});