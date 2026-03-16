<?php

use App\Http\Controllers\Frontend\MemberController;
use Illuminate\Support\Facades\Route;


// Routes สมาชิกในครอบครัว (Member)
    Route::prefix('member')->group(function(){
    Route::get('/add/{client_id}', [MemberController::class, 'AddMember'])->name('member.create');
   Route::get('/show/{client_id}', [MemberController::class, 'ShowMember'])->name('member.show');
    Route::post('/store', [MemberController::class, 'StoreMember'])->name('member.store');
    Route::get('/edit/{id}', [MemberController::class, 'EditMember'])->name('member.edit');
    Route::put('/update/{id}', [MemberController::class, 'UpdateMember'])->name('member.update');
    Route::delete('/delete/{id}', [MemberController::class, 'DeleteMember'])->name('member.delete');
   
});
