<?php


use App\Http\Controllers\Frontend\HelpSessionController;
use Illuminate\Support\Facades\Route;

/// Routes การช่วยเหลือเครื่องอุปโภค/บริโภค (HelpSession)
Route::prefix('clients/{client}')->group(function () {
    // แสดงการช่วยเหลือทั้งหมดของ client
    Route::get('help-sessions', [HelpSessionController::class, 'show'])
        ->name('help_sessions.show');

    // หน้า form เพิ่มการช่วยเหลือใหม่
    Route::get('help-sessions/create', [HelpSessionController::class, 'create'])
        ->name('help_sessions.create');

    // บันทึกการช่วยเหลือใหม่
    Route::post('help-sessions', [HelpSessionController::class, 'store'])
        ->name('help_sessions.store');

    // หน้า form แก้ไขการช่วยเหลือ
    Route::get('help-sessions/{session}/edit', [HelpSessionController::class, 'edit'])
        ->name('help_sessions.edit');

    // อัปเดตการช่วยเหลือ
    Route::put('help-sessions/{session}', [HelpSessionController::class, 'update'])
        ->name('help_sessions.update');

    // ลบการช่วยเหลือ
    Route::delete('help-sessions/{session}', [HelpSessionController::class, 'destroy'])
        ->name('help_sessions.destroy');
});
