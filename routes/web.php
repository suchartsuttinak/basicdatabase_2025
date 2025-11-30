<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\backend\ClientController;
use App\Http\Controllers\backend\InstitutionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// Admin Logout
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

// Admin Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'ProfileStore'])->name('profile.store');
    Route::post('/admin/password/update', [AdminController::class, 'PasswordUpdate'])->name('admin.password.update');  
});

// Institution Modal Route All
Route::middleware('auth')->group(function () {
    Route::get('/institution', [InstitutionController::class, 'InstitutionAll'])->name('institution.all');
    Route::post('/store/institution', [InstitutionController::class, 'InstitutionStore'])->name('institution.store');
    Route::get('/edit/institution/{id}', [InstitutionController::class, 'EditInstitution']);
    Route::post('/update/institution', [InstitutionController::class, 'UpdateInstitution'])->name('institution.update');
    Route::get('/delete/institution/{id}', [InstitutionController::class, 'DeleteInstitution'])->name('institution.delete');
});


// Client Route All
    Route::middleware('auth')->group(function () {
    Route::get('/client', [ClientController::class, 'clientAll'])->name('client.all');
    Route::get('/client/add', [ClientController::class, 'clientAdd'])->name('client.add');
    Route::post('/client/store', [ClientController::class, 'ClientStore'])->name('client.store');


  
    // dynamic route (ถ้าเป็นของ ClientController)
    Route::get('/get-districts/{province}', [ClientController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district}', [ClientController::class, 'getSubdistricts']);
    Route::get('/get-zipcode/{subdistrict}', [ClientController::class, 'getZipcode']);
});




        