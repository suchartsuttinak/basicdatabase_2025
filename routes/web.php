<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\backend\ClientController;
use App\Http\Controllers\backend\PsychoController;
use App\Http\Controllers\backend\SubjectController;
use App\Http\Controllers\Frontend\AbsentController;
use App\Http\Controllers\Frontend\EscapeController;
use App\Http\Controllers\Frontend\FamilyController;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Frontend\MedicalController;
use App\Http\Controllers\Frontend\ObserveController;
use App\Http\Controllers\Frontend\AccidentController;
use App\Http\Controllers\Frontend\AddictiveController;
use App\Http\Controllers\Frontend\CheckBodyController;
use App\Http\Controllers\backend\InstitutionController;
use App\Http\Controllers\backend\MisbehaviorController;
use App\Http\Controllers\Frontend\FactfindingController;
use App\Http\Controllers\Frontend\PsychiatricController;
use App\Http\Controllers\Frontend\VaccinationController;
use App\Http\Controllers\Frontend\VisitFamilyController;
use App\Http\Controllers\Frontend\EscapeFollowController;
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

// Psycho Modal Route All
Route::middleware('auth')->group(function () {
    Route::get('/psycho', [PsychoController::class, 'ShowPsycho'])->name('psycho.show');
    Route::post('/store/psycho', [PsychoController::class, 'StorePsycho'])->name('psycho.store');
    Route::get('/edit/psycho/{id}', [PsychoController::class, 'EditPsycho']);
    Route::post('/update/psycho', [PsychoController::class, 'UpdatePsycho'])->name('psycho.update');
    Route::get('/delete/psycho/{id}', [PsychoController::class, 'DeletePsycho'])->name('psycho.delete');

});

// Misbehavior Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/misbehavior', [MisbehaviorController::class, 'ShowMisbehavior'])->name('misbehavior.show');
    Route::post('/store/misbehavior', [MisbehaviorController::class, 'StoreMisbehavior'])->name('misbehavior.store');
    Route::get('/edit/misbehavior/{id}', [MisbehaviorController::class, 'EditMisbehavior']);
    Route::post('/update/misbehavior', [MisbehaviorController::class, 'UpdateMisbehavior'])->name('misbehavior.update');
    Route::get('/delete/misbehavior/{id}', [MisbehaviorController::class, 'DeleteMisbehavior'])->name('misbehavior.delete');

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


// 🏫 ตรวจสุขภาพเบื้องต้น
Route::prefix('check_body')->name('check_body.')->group(function () {
    // แสดงฟอร์มเพิ่มข้อมูล (client_id จำเป็น)
    Route::get('/add/{client_id}', [CheckBodyController::class, 'CheckBodyAdd'])->name('add');
     // บันทึกข้อมูลใหม่
    Route::post('/store', [CheckBodyController::class, 'CheckBodyStore'])->name('store');

    // ใช้ฟอร์มเดิมในการแก้ไข (ส่ง accident id)
    Route::get('/edit/{id}', [CheckBodyController::class, 'CheckBodyEdit'])->name('edit');

    // อัปเดตข้อมูล (PUT)
    Route::put('/update/{id}', [CheckBodyController::class, 'CheckBodyUpdate'])->name('update');

    // ลบข้อมูล
    Route::delete('/delete/{id}', [CheckBodyController::class, 'CheckBodyDelete'])->name('delete');

    // ✅ เพิ่ม route สำหรับรายงาน (ตรงกับปุ่มใน view)
    Route::get('/report/{id}', [CheckBodyController::class, 'CheckBodyReport'])->name('report');
});


// 🏫 บันทึกการการรักษาพยาบาลในหน่วยงาน
Route::prefix('medical')->name('medical.')->group(function () {
    // แสดงฟอร์มเพิ่มข้อมูล (client_id จำเป็น)
    Route::get('/add/{client_id}', [MedicalController::class, 'MedicalAdd'])->name('add');

    // บันทึกข้อมูลใหม่
    Route::post('/store', [MedicalController::class, 'MedicalStore'])->name('store');

    // ใช้ฟอร์มเดิมในการแก้ไข (ส่ง accident id)
    Route::get('/edit/{id}', [MedicalController::class, 'MedicalEdit'])->name('edit');

    // อัปเดตข้อมูล (PUT)
    Route::put('/update/{id}', [MedicalController::class, 'MedicalUpdate'])->name('update');

    // ลบข้อมูล
    Route::delete('/delete/{id}', [MedicalController::class, 'MedicalDelete'])->name('delete');

    // ✅ เพิ่ม route สำหรับรายงาน (ตรงกับปุ่มใน view)
    Route::get('/report/{id}', [MedicalController::class, 'MedicalReport'])->name('report');
});


// Vaccination Modal Route All
Route::prefix('vaccine')->name('vaccine.')->group(function () {
    // แสดงรายการวัคซีนของ client
    Route::get('/add/{client_id}', [VaccinationController::class, 'VaccineShow'])->name('index');

    // บันทึกข้อมูลวัคซีนใหม่
    Route::post('/store', [VaccinationController::class, 'VaccineStore'])->name('store');

    // ดึงข้อมูลวัคซีนมาแก้ไข (ใช้กับ AJAX Modal)
    Route::get('/edit/{id}', [VaccinationController::class, 'VaccineEdit'])->name('edit');

    // อัปเดตข้อมูลวัคซีน (ต้องใช้ PUT)
    Route::put('/update/{id}', [VaccinationController::class, 'VaccineUpdate'])->name('update');

    // ลบข้อมูลวัคซีน (ต้องใช้ DELETE)
    Route::delete('/delete/{id}', [VaccinationController::class, 'VaccineDelete'])->name('delete');
});

// บันทึกการตรวจวินิจฉัยทางจิตเวช Psychiatric
Route::prefix('psychiatric')->group(function(){
    Route::get('/add/{client_id}', [PsychiatricController::class, 'AddPsychiatric'])->name('psychiatric.create');
    Route::post('/store', [PsychiatricController::class, 'StorePsychiatric'])->name('psychiatric.store');
    Route::get('/edit/{id}', [PsychiatricController::class, 'EditPsychiatric'])->name('psychiatric.edit');
    Route::put('/update/{id}', [PsychiatricController::class, 'UpdatePsychiatric'])->name('psychiatric.update');
    Route::delete('/delete/{id}', [PsychiatricController::class, 'DeletePsychiatric'])->name('psychiatric.delete');
});

// บันทึกการตรวจสารเสพติด Addictive
Route::prefix('addictive')->group(function(){
    Route::get('/add/{client_id}', [AddictiveController::class, 'AddAddictive'])->name('addictive.create');
    Route::post('/store', [AddictiveController::class, 'StoreAddictive'])->name('addictive.store');
    Route::get('/edit/{id}', [AddictiveController::class, 'EditAddictive'])->name('addictive.edit');
    Route::put('/update/{id}', [AddictiveController::class, 'UpdateAddictive'])->name('addictive.update');
    Route::delete('/delete/{id}', [AddictiveController::class, 'DeleteAddictive'])->name('addictive.delete');
   
});

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

// Vitsit_Family Route All
Route::prefix('vitsitFamily')->group(function () {
    Route::get('/add/{client_id}', [VisitFamilyController::class, 'AddvisitFamily'])->name('visitFamily.create');
    Route::post('/store/{client_id}', [VisitFamilyController::class, 'StoreVisitFamily'])->name('vitsitFamily.store');
    Route::get('/edit/{id}', [VisitFamilyController::class, 'EditVisitFamily'])->name('vitsitFamily.edit');
    Route::put('/update/{id}', [VisitFamilyController::class, 'UpdateVisitFamily'])->name('vitsitFamily.update');
  
    // (ตัวเลือก) ถ้าจะทำ “แทนที่รูป” ให้เพิ่ม route นี้
    Route::patch('/image/{id}', [VisitFamilyController::class, 'replaceImage'])->name('image.replace');

    // ชี้ไปที่ VisitFamilyController@destroy ให้ตรงกับเมธอดที่มีอยู่
     Route::delete('/vitsitFamily/image/{id}', [VisitFamilyController::class, 'destroy'])
        ->name('image.destroy');

    // Ajax Route จังหวัด-อำเภอ-ตำบล-รหัสไปรษณีย์
    Route::get('/get-districts/{province_id}', [VisitFamilyController::class, 'getDistricts'])
        ->name('vitsitFamily.getDistricts');

    Route::get('/get-subdistricts/{district_id}', [VisitFamilyController::class, 'getSubdistricts'])
        ->name('vitsitFamily.getSubdistricts');

    Route::get('/get-zipcode/{subdistrict_id}', [VisitFamilyController::class, 'getZipcode'])
        ->name('vitsitFamily.getZipcode');
});

// Routes สมาชิกในครอบครัว (Member)
Route::prefix('member')->group(function(){
    Route::get('/add/{client_id}', [MemberController::class, 'AddMember'])->name('member.create');
   Route::get('/show/{client_id}', [MemberController::class, 'ShowMember'])->name('member.show');
    Route::post('/store', [MemberController::class, 'StoreMember'])->name('member.store');
    Route::get('/edit/{id}', [MemberController::class, 'EditMember'])->name('member.edit');
    Route::put('/update/{id}', [MemberController::class, 'UpdateMember'])->name('member.update');
    Route::delete('/delete/{id}', [MemberController::class, 'DeleteMember'])->name('member.delete');
   
});


/// Escape หลัก
Route::prefix('escape')->group(function(){
    // หน้า index แสดง Escape ทั้งหมด
    Route::get('/index/{client_id}', [EscapeController::class, 'IndexEscape'])->name('escape.index');

    // หน้า add escape ใหม่
    Route::get('/add/{client_id}', [EscapeController::class, 'AddEscape'])->name('escape.add');

    // บันทึก escape ใหม่
    Route::post('/store', [EscapeController::class, 'StoreEscape'])->name('escape.store');

    // หน้า edit escape ตาม id
    Route::get('/edit/{id}', [EscapeController::class, 'EditEscape'])->name('escape.edit');

    // อัปเดต escape ตาม id
    Route::put('/update/{id}', [EscapeController::class, 'UpdateEscape'])->name('escape.update');

    // ✅ เพิ่ม route สำหรับลบ escape
    Route::delete('/delete/{id}', [EscapeController::class, 'DeleteEscape'])->name('escape.delete');
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



 
   

