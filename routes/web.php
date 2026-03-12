<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\backend\ClientController;
use App\Http\Controllers\backend\DocumentController;
use App\Http\Controllers\backend\EducationController;
use App\Http\Controllers\backend\HelpTypeController;
use App\Http\Controllers\backend\IncomeController;
use App\Http\Controllers\backend\InstitutionController;
use App\Http\Controllers\backend\MisbehaviorController;
use App\Http\Controllers\backend\OutsideController;
use App\Http\Controllers\backend\PsychoController;
use App\Http\Controllers\backend\SemesterController;
use App\Http\Controllers\backend\SubjectController;
use App\Http\Controllers\backend\TranslateController;
use App\Http\Controllers\ClientAdmin\AdminClientController;
use App\Http\Controllers\Frontend\AbsentController;
use App\Http\Controllers\Frontend\AccidentController;
use App\Http\Controllers\Frontend\AddictiveController;
use App\Http\Controllers\Frontend\CaseOutsideController;
use App\Http\Controllers\Frontend\CheckBodyController;
use App\Http\Controllers\Frontend\EducationRecordController;
use App\Http\Controllers\Frontend\EscapeController;
use App\Http\Controllers\Frontend\EscapeFollowController;
use App\Http\Controllers\Frontend\EstimateController;
use App\Http\Controllers\Frontend\FactfindingController;
use App\Http\Controllers\Frontend\FamilyController;
use App\Http\Controllers\Frontend\HelpSessionController;
use App\Http\Controllers\Frontend\JobAgencyController;
use App\Http\Controllers\Frontend\MedicalController;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Frontend\ObserveController;
use App\Http\Controllers\Frontend\PsychiatricController;
use App\Http\Controllers\Frontend\ReferController;
use App\Http\Controllers\Frontend\SchoolFollowupController;
use App\Http\Controllers\Frontend\VaccinationController;
use App\Http\Controllers\Frontend\VisitFamilyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



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

// Outside Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/outside', [OutsideController::class, 'ShowOutside'])->name('outside.show');
    Route::post('/store/outside', [OutsideController::class, 'StoreOutside'])->name('outside.store');
    Route::get('/edit/outside/{id}', [OutsideController::class, 'EditOutside']);
    Route::post('/update/outside', [OutsideController::class, 'UpdateOutside'])->name('outside.update');
    Route::get('/delete/outside/{id}', [OutsideController::class, 'DeleteOutside'])->name('outside.delete');
});

// Document Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/document', [DocumentController::class, 'ShowDocument'])->name('document.show');
    Route::post('/store/document', [DocumentController::class, 'StoreDocument'])->name('document.store');
    Route::get('/edit/document/{id}', [DocumentController::class, 'EditDocument']);
    Route::post('/update/document', [DocumentController::class, 'UpdateDocument'])->name('document.update');
    Route::get('/delete/document/{id}', [DocumentController::class, 'DeleteDocument'])->name('document.delete');
});

// Education Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/education', [EducationController::class, 'ShowEducation'])->name('education.show');
    Route::post('/store/education', [EducationController::class, 'StoreEducation'])->name('education.store');
    Route::get('/edit/education/{id}', [EducationController::class, 'EditEducation']);
    Route::post('/update/education', [EducationController::class, 'UpdateEducation'])->name('education.update');
    Route::get('/delete/education/{id}', [EducationController::class, 'DeleteEducation'])->name('education.delete');
});
// Income Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/income', [IncomeController::class, 'ShowIncome'])->name('income.show');
    Route::post('/store/income', [IncomeController::class, 'StoreIncome'])->name('income.store');
    Route::get('/edit/income/{id}', [IncomeController::class, 'EditIncome']);
    Route::post('/update/income', [IncomeController::class, 'UpdateIncome'])->name('income.update');
    Route::get('/delete/income/{id}', [IncomeController::class, 'DeleteIncome'])->name('income.delete');
});
// Help Type Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/help_type', [HelpTypeController::class, 'ShowHelpType'])->name('help_type.show');
    Route::post('/store/help_type', [HelpTypeController::class, 'StoreHelpType'])->name('help_type.store');
    Route::get('/edit/help_type/{id}', [HelpTypeController::class, 'EditHelpType']);
    Route::post('/update/help_type', [HelpTypeController::class, 'UpdateHelpType'])->name('help_type.update');
    Route::get('/delete/help_type/{id}', [HelpTypeController::class, 'DeleteHelpType'])->name('help_type.delete');
});
// Semester Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/semester', [SemesterController::class, 'SemesterShow'])->name('semester.show');
    Route::post('/store/semester', [SemesterController::class, 'SemesterStore'])->name('semester.store');
    Route::get('/edit/semester/{id}', [SemesterController::class, 'EditSemester']);
    Route::post('/update/semester', [SemesterController::class, 'UpdateSemester'])->name('semester.update');
    Route::get('/delete/semester/{id}', [SemesterController::class, 'DeleteSemester'])->name('semester.delete');
});

// translates Modal Route All
    Route::middleware('auth')->group(function () {
    Route::get('/translate', [TranslateController::class, 'ShowTranslate'])->name('translate.show');
    Route::post('/store/translate', [TranslateController::class, 'StoreTranslate'])->name('translate.store');
    Route::get('/edit/translate/{id}', [TranslateController::class, 'EditTranslate']);
    Route::post('/update/translate', [TranslateController::class, 'UpdateTranslate'])->name('translate.update');
    Route::get('/delete/translate/{id}', [TranslateController::class, 'DeleteTranslate'])->name('translate.delete');
});

// Client Route All
    Route::middleware('auth')->group(function () {
    Route::get('/client', [ClientController::class, 'clientShow'])->name('client.show');
    Route::get('/client/refer', [ClientController::class, 'clientShowRefer'])->name('client.show_refer');
    Route::get('/client/add', [ClientController::class, 'clientAdd'])->name('client.add');
    Route::post('/client/store', [ClientController::class, 'ClientStore'])->name('client.store');
    Route::get('/client/edit/{id}', [ClientController::class, 'ClientEdit'])->name('client.edit');
    Route::post('/client/update', [ClientController::class, 'ClientUpdate'])->name('client.update');
    Route::get('/client/delete/{id}', [ClientController::class, 'ClientDelete'])->name('client.delete');

    // ✅ เพิ่ม route สำหรับเปลี่ยนสถานะ client จาก refer → show
    Route::post('/client/change-status/{id}', [ClientController::class, 'changeStatus'])
     ->name('client.changeStatus');


    
// Ajax Route All จังหวัด-อําเภอ-ตําบล
    Route::get('/get-districts/{province_id}', [ClientController::class, 'getDistricts']);
    Route::get('/get-subdistricts/{district_id}', [ClientController::class, 'getSubdistricts']);
    Route::get('/get-zipcode/{subdistrict_id}', [ClientController::class, 'getZipcode']); 

     // ✅ Ajax Route All จังหวัด-อำเภอ-ตำบล (ภูมิลำเนาเดิม)
    Route::get('/get-origin-districts/{province_id}', [ClientController::class, 'getOriginDistricts']);
    Route::get('/get-origin-subdistricts/{district_id}', [ClientController::class, 'getOriginSubdistricts']);
    Route::get('/get-origin-zipcode/{subdistrict_id}', [ClientController::class, 'getOriginZipcode']);
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


    Route::prefix('absent')->name('absent.')->group(function () {
    Route::get('/add/{client_id}', [AbsentController::class, 'AbsentAdd'])->name('add');
    Route::post('/store', [AbsentController::class, 'AbsentStore'])->name('store');
    Route::get('/edit/{id}', [AbsentController::class, 'AbsentEdit'])->name('edit'); // ✅ JSON สำหรับ AJAX
    Route::get('/edit-view/{id}', [AbsentController::class, 'AbsentEditView'])->name('edit.view'); // ✅ View
    // ✅ Update รองรับทั้ง AJAX และ redirect
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

    Route::get('/index/{client_id}', [EscapeController::class, 'IndexEscape'])->name('escape.index');


});


// 🏫 บันทึกการรักษาพยาบาลในหน่วยงาน
Route::prefix('medical')->name('medical.')->group(function () {
    // ✅ แสดงฟอร์มเพิ่มข้อมูลใหม่ (client_id จำเป็น)
    Route::get('/add/{client_id}', [MedicalController::class, 'MedicalAdd'])->name('add');

    // ✅ บันทึกข้อมูลใหม่
    Route::post('/store', [MedicalController::class, 'MedicalStore'])->name('store');

    // ❌ ตัดออก: ไม่ต้องใช้ MedicalEdit แล้ว
    // Route::get('/edit/{id}', [MedicalController::class, 'MedicalEdit'])->name('edit');

    // ✅ อัปเดตข้อมูล (PUT)
    Route::put('/update/{id}', [MedicalController::class, 'MedicalUpdate'])->name('update');

    // ✅ ลบข้อมูล
    Route::delete('/delete/{id}', [MedicalController::class, 'MedicalDelete'])->name('delete');

    // ✅ รายงาน
    Route::get('/report/{id}', [MedicalController::class, 'MedicalReport'])->name('report');

    // ✅ โหลดข้อมูล JSON สำหรับ modal edit
    Route::get('/json/{id}', [MedicalController::class, 'editMedicalJson'])->name('json');
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
        Route::prefix('psychiatric')->group(function () {
            // เพิ่มข้อมูลใหม่
            Route::get('/add/{client_id}', [PsychiatricController::class, 'AddPsychiatric'])
                ->name('psychiatric.create');

            // บันทึกข้อมูลใหม่
            Route::post('/store', [PsychiatricController::class, 'StorePsychiatric'])
                ->name('psychiatric.store');

            // สำหรับเรียกข้อมูลมาแก้ไข (JSON)
            Route::get('/edit-json/{id}', [PsychiatricController::class, 'EditPsychiatricJson'])
                ->name('psychiatric.edit.json');

            // สำหรับอัปเดตข้อมูล (PUT)
            Route::put('/{id}', [PsychiatricController::class, 'UpdatePsychiatric'])
                ->name('psychiatric.update');

            // ลบข้อมูล
            Route::delete('/delete/{id}', [PsychiatricController::class, 'DeletePsychiatric'])
                ->name('psychiatric.delete');
        });

            Route::prefix('addictive')->group(function(){
            Route::get('/add/{client_id}', [AddictiveController::class, 'AddAddictive'])->name('addictive.create');
            Route::post('/store', [AddictiveController::class, 'StoreAddictive'])->name('addictive.store');
            Route::get('/edit/{id}', [AddictiveController::class, 'EditAddictive'])->name('addictive.edit');
            Route::put('/update/{id}', [AddictiveController::class, 'UpdateAddictive'])->name('addictive.update');
            Route::delete('/delete/{id}', [AddictiveController::class, 'DeleteAddictive'])->name('addictive.delete');

            // ✅ JSON สำหรับโหลดข้อมูลไปใส่ใน modal edit
            Route::get('/json/{id}', [AddictiveController::class, 'EditAddictiveJson'])->name('addictive.json');
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

   // Routes ประเมินครอบครัว (Estimate)
   Route::prefix('estimate')->group(function(){
    Route::get('/show/{client_id}', [EstimateController::class, 'ShowEstimate'])->name('estimate.show');
    Route::post('/store', [EstimateController::class, 'StoreEstimate'])->name('estimate.store');
    Route::get('/edit/{id}', [EstimateController::class, 'EditEstimate'])->name('estimate.edit');
    Route::put('/update/{id}', [EstimateController::class, 'UpdateEstimate'])->name('estimate.update');
    Route::delete('/delete/{id}', [EstimateController::class, 'DeleteEstimate'])->name('estimate.delete');


    Route::get('/estimate/check-duplicate', [EstimateController::class, 'CheckDuplicate']);
});


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

// Routes ติดตามเด็กที่อยู่นอกสถานสงเคราะห์ (CaseOutside)
    Route::prefix('case-outside')->group(function(){
    Route::get('/show/{client_id}', [CaseOutsideController::class, 'ShowCaseOutside'])->name('case_outside.show');
    Route::post('/store', [CaseOutsideController::class, 'StoreCaseOutside'])->name('case_outside.store');
    Route::put('/update/{id}', [CaseOutsideController::class, 'UpdateCaseOutside'])->name('case_outside.update');
    Route::delete('/delete/{id}', [CaseOutsideController::class, 'DeleteCaseOutside'])->name('case_outside.delete');
});

// Routes ติดตามเด็กที่อยู่นอกสถานสงเคราะห์ (CaseOutside)
    Route::prefix('refer')->group(function(){
    Route::get('/refers/{client_id}', [ReferController::class, 'index'])->name('refers.index');
    Route::post('/refers/store', [ReferController::class, 'store'])->name('refers.store');
    Route::put('/refers/{id}/restore', [ReferController::class, 'restore'])->name('refers.restore');
});

// Routes ติดตามเด็กที่อยู่นอกสถานสงเคราะห์ (JobAgency)
  Route::prefix('job-agency')->group(function(){
    Route::get('/show/{client_id}', [JobAgencyController::class, 'showJobAgency'])->name('job_agencies.show');
    Route::post('/store', [JobAgencyController::class, 'storeJobAgency'])->name('job_agencies.store');
    Route::put('/update/{id}', [JobAgencyController::class, 'updateJobAgency'])->name('job_agencies.update');
    Route::delete('/delete/{id}', [JobAgencyController::class, 'deleteJobAgency'])->name('job_agencies.delete');
});

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


 






    
  




