<?php


use App\Http\Controllers\Frontend\ObserveController;
use Illuminate\Support\Facades\Route;

// Routes สำหรับพฤติกรรม (Observe)
    Route::prefix('observe')->group(function(){
    Route::get('/add/{client_id}', [ObserveController::class, 'AddObserve'])->name('observe.create');
    Route::post('/store', [ObserveController::class, 'StoreObserve'])->name('observe.store');
    Route::get('/edit/{id}', [ObserveController::class, 'EditObserve'])->name('observe.edit');
    Route::put('/update/{id}', [ObserveController::class, 'UpdateObserve'])->name('observe.update');
    Route::delete('/delete/{id}', [ObserveController::class, 'DeleteObserve'])->name('observe.delete');
});

// Routes สำหรับการติดตามผล (Followup)
    Route::prefix('followup')->group(function(){
    Route::post('/store', [ObserveController::class, 'StoreFollowup'])->name('followup.store');
    Route::get('/edit/{id}', [ObserveController::class, 'EditFollowup'])->name('followup.edit');
    Route::put('/update/{id}', [ObserveController::class, 'UpdateFollowup'])->name('followup.update');
    Route::delete('/delete/{id}', [ObserveController::class, 'DeleteFollowup'])->name('followup.delete');
});