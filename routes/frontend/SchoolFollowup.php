<?php

use App\Http\Controllers\Frontend\SchoolFollowupController;
use Illuminate\Support\Facades\Route;

// 🏫 บันทึกการติดตามเด็กในโรงเรียน
    Route::prefix('school_followup')->group(function () {
    Route::get('/add/{client_id}', [SchoolFollowupController::class, 'SchoolFollowupAdd'])->name('school_followup_add');
    Route::post('/store', [SchoolFollowupController::class, 'SchoolFollowupStore'])->name('school_followup_store');
   Route::get('/edit/{id}', [SchoolFollowupController::class, 'SchoolFollowupEdit'])->name('school_followup.edit');
    Route::put('/update/{id}', [SchoolFollowupController::class, 'SchoolFollowupUpdate'])->name('school_followup.update');
    Route::delete('/delete/{id}', [SchoolFollowupController::class, 'SchoolFollowupDelete'])->name('school_followup.delete');

    // ✅ รายงานตาม followup_id
    Route::get('/{followup_id}', [SchoolFollowupController::class, 'SchoolFollowupReport'])
        ->whereNumber('followup_id')
        ->name('school_followup.report');
});