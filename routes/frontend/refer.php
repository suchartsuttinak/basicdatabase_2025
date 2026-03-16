<?php


use App\Http\Controllers\Frontend\ReferController;
use Illuminate\Support\Facades\Route;


// Routes ติดตามเด็กที่อยู่นอกสถานสงเคราะห์ (CaseOutside)
    Route::prefix('refer')->group(function(){
    Route::get('/refers/{client_id}', [ReferController::class, 'index'])->name('refers.index');
    Route::post('/refers/store', [ReferController::class, 'store'])->name('refers.store');
    Route::put('/refers/{id}/restore', [ReferController::class, 'restore'])->name('refers.restore');
});
