<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\backend\ClientController;
use App\Http\Controllers\backend\SubjectController;
use App\Http\Controllers\Frontend\AbsentController;
use App\Http\Controllers\Frontend\FamilyController;
use App\Http\Controllers\Frontend\AccidentController;
use App\Http\Controllers\backend\InstitutionController;
use App\Http\Controllers\Frontend\FactfindingController;
use App\Http\Controllers\ClientAdmin\AdminClientController;
use App\Http\Controllers\Frontend\SchoolFollowupController;
use App\Http\Controllers\Frontend\EducationRecordController;



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

// Subject Modal Route All
Route::middleware('auth')->group(function () {
    Route::get('/subject', [SubjectController::class, 'SubjectShow'])->name('subject.show');
    Route::post('/store/subject', [SubjectController::class, 'SubjectStore'])->name('subject.store');
    Route::get('/edit/subject/{id}', [SubjectController::class, 'EditSubject']);
    Route::post('/update/subject', [SubjectController::class, 'UpdateSubject'])->name('subject.update');
    Route::get('/delete/subject/{id}', [SubjectController::class, 'DeleteSubject'])->name('subject.delete');
});



// Client Route All
    Route::middleware('auth')->group(function () {
    Route::get('/client', [ClientController::class, 'clientShow'])->name('client.show');
    Route::get('/client/add', [ClientController::class, 'clientAdd'])->name('client.add');
    Route::post('/client/store', [ClientController::class, 'ClientStore'])->name('client.store');
    Route::get('/client/edit/{id}', [ClientController::class, 'ClientEdit'])->name('client.edit');
    Route::post('/client/update', [ClientController::class, 'ClientUpdate'])->name('client.update');
    Route::get('/client/delete/{id}', [ClientController::class, 'ClientDelete'])->name('client.delete');
 
// Ajax Route All จังหวัด-อําเภอ-ตําบล
    Route::get('/get-districts/{province_id}', [ClientController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district_id}', [ClientController::class, 'getSubdistricts']);
    Route::get('/get-zipcode/{subdistrict_id}', [ClientController::class, 'getZipcode']); 
});

// AdminClient Route All
Route::middleware('auth')->group(function () {
    Route::get('/admin/client/{id}', [AdminClientController::class, 'Index'])->name('admin.index');
    Route::get('/client/report/{id}', [AdminClientController::class, 'ClientReport'])->name('client.report');
});

// Facfiding Route All
Route::middleware('auth')->group(function () {
    // เพิ่ม factfinding ใหม่ โดยส่ง client_id
    Route::get('/factfinding/add/{client_id}', [FactfindingController::class, 'FactfindingAdd'])
        ->name('factfinding.add');

    // บันทึก factfinding
    Route::post('/factfinding/store', [FactfindingController::class, 'FactfindingStore'])
        ->name('factfinding.store');

    // แก้ไข factfinding
       Route::get('/factfinding/edit/{factfinding_id}', [FactfindingController::class, 'FactfindingEdit'])
    ->name('factfinding.edit');



    // บันทึก factfinding
   Route::post('/factfinding/update/{id}', [FactfindingController::class, 'FactfindingUpdate'])
     ->name('factfinding.update');
});


    // Family Route All
    Route::middleware('auth')->group(function () {
    Route::get('/family/add/{client_id}', [FamilyController::class, 'FamilyAdd'])->name('family.add'); 
    Route::post('/family/store', [FamilyController::class, 'FamilyStore'])->name('family.store');
   


   // Ajax Route All จังหวัด-อำเภอ-ตำบล
    Route::get('/get-districts/{province_id}', [FamilyController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district_id}', [FamilyController::class, 'getSubdistricts']);
    Route::get('/get-zipcode/{subdistrict_id}', [FamilyController::class, 'getZipcode']);

});

// Education Record Route All
Route::middleware('auth')->group(function () {
    // เปิดฟอร์ม (GET)
    Route::get('/education_record/add/{client_id}', 
        [EducationRecordController::class, 'EducationRecordAdd']
    )->name('education_record.add');  

    // บันทึกข้อมูล (POST)
    Route::post('/education_record/store', [EducationRecordController::class, 'EducationRecordStore']
        )->name('education_record.store');  

    // แสดงข้อมูลการศึกษา (GET)
    Route::get('/education_record/show/{client_id}', 
        [EducationRecordController::class, 'EducationRecordShow']
        )->name('education_record_show');

    // แก้ไขข้อมูลการศึกษา (GET)
    Route::get('/education_record/edit/{id}', 
        [EducationRecordController::class, 'EducationRecordEdit']
        )->name('education_record.edit');

    // บันทึกข้อมูลการศึกษา (POST)
    Route::post('/education_record/update/{id}', 
        [EducationRecordController::class, 'EducationRecordUpdate']
        )->name('education_record_update');
});

    // 📚 บันทึกผลการเรียน
    Route::prefix('education-record')->group(function () {
        Route::get('/add/{client_id}', 
            [EducationRecordController::class, 'EducationRecordAdd']
        )->name('education_record_add');

        Route::post('/store', 
            [EducationRecordController::class, 'EducationRecordStore']
        )->name('education_record_store');

        Route::get('/{client_id}', 
            [EducationRecordController::class, 'EducationRecordShow']
        )->name('education_record_show');

        Route::get('/edit/{id}', 
            [EducationRecordController::class, 'EducationRecordEdit']
        )->name('education_record_edit');

        Route::put('/update/{id}', 
            [EducationRecordController::class, 'EducationRecordUpdate']
        )->name('education_record_update');

        Route::delete('/delete/{id}', 
            [EducationRecordController::class, 'EducationRecordDelete']
        )->name('education_record_delete');
    });


    
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


/// 🏫 บันทึกการขาดเรียนของเด็ก
Route::prefix('absent')->name('absent.')->group(function () {
    Route::get('/add/{client_id}', [AbsentController::class, 'AbsentAdd'])->name('add');
    Route::post('/store', [AbsentController::class, 'AbsentStore'])->name('store');
    Route::get('/edit/{id}', [AbsentController::class, 'AbsentEdit'])->name('edit');
    Route::put('/update/{id}', [AbsentController::class, 'AbsentUpdate'])->name('update');
    Route::delete('/delete/{id}', [AbsentController::class, 'AbsentDelete'])->name('delete');
    Route::get('/report/{id}', [AbsentController::class, 'AbsentReport'])->name('report');
});

// 🏫 บันทึกการบาดเจ็บของเด็ก
Route::prefix('accident')->name('accident.')->group(function () {
    // แสดงฟอร์มเพิ่มข้อมูล (client_id จำเป็น)
    Route::get('/add/{client_id}', [AccidentController::class, 'AccidentAdd'])->name('add');

    // บันทึกข้อมูลใหม่
    Route::post('/store', [AccidentController::class, 'AccidentStore'])->name('store');

    // ใช้ฟอร์มเดิมในการแก้ไข (ส่ง accident id)
    Route::get('/edit/{id}', [AccidentController::class, 'AccidentEdit'])->name('edit');

    // อัปเดตข้อมูล (PUT)
    Route::put('/update/{id}', [AccidentController::class, 'AccidentUpdate'])->name('update');

    // ลบข้อมูล
    Route::delete('/delete/{id}', [AccidentController::class, 'AccidentDelete'])->name('delete');

    // ✅ เพิ่ม route สำหรับรายงาน (ตรงกับปุ่มใน view)
    Route::get('/report/{id}', [AccidentController::class, 'AccidentReport'])->name('report');
});

