<?php

use App\Http\Controllers\Frontend\JobAgencyController;
use Illuminate\Support\Facades\Route;


// Routes ติดตามเด็กที่อยู่นอกสถานสงเคราะห์ (JobAgency)
  Route::prefix('job-agency')->group(function(){
    Route::get('/show/{client_id}', [JobAgencyController::class, 'showJobAgency'])->name('job_agencies.show');
    Route::post('/store', [JobAgencyController::class, 'storeJobAgency'])->name('job_agencies.store');
    Route::put('/update/{id}', [JobAgencyController::class, 'updateJobAgency'])->name('job_agencies.update');
    Route::delete('/delete/{id}', [JobAgencyController::class, 'deleteJobAgency'])->name('job_agencies.delete');
});