<?php


use App\Http\Controllers\Frontend\EscapeController;
use App\Http\Controllers\Frontend\EscapeFollowController;
use Illuminate\Support\Facades\Route;


/// Escape หลัก
    Route::prefix('escape')->group(function(){
    Route::get('/index/{client_id}', [EscapeController::class, 'IndexEscape'])->name('escape.index');
    Route::get('/add/{client_id}', [EscapeController::class, 'AddEscape'])->name('escape.add');
    Route::post('/store', [EscapeController::class, 'StoreEscape'])->name('escape.store');
    Route::get('/edit/{id}', [EscapeController::class, 'EditEscape'])->name('escape.edit');
    Route::put('/update/{id}', [EscapeController::class, 'UpdateEscape'])->name('escape.update');
    Route::delete('/delete/{id}', [EscapeController::class, 'DeleteEscape'])->name('escape.delete');

    // ✅ เปลี่ยน CopyEscape ให้เป็น GET
    Route::get('/copy/{id}', [EscapeController::class, 'CopyEscape'])->name('escape.copy');
});

// EscapeFollow
    Route::prefix('escape-follows')->group(function(){
    // เพิ่มการติดตามใหม่
    Route::post('/store/{escape_id}', [EscapeFollowController::class, 'StoreFollow'])->name('escape_follows.store');

    // อัปเดตการติดตาม
    Route::put('/update/{id}', [EscapeFollowController::class, 'UpdateFollow'])->name('escape_follows.update');

    // ลบการติดตาม
    Route::delete('/delete/{id}', [EscapeFollowController::class, 'DeleteFollow'])->name('escape_follows.delete');
});
/// สิ้นสุด Escape หลัก