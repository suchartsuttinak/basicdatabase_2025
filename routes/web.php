<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientAdmin\AdminClientController;
use App\Http\Controllers\Frontend\ClientFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;


// ประมวลผล/สถิติ หน้า dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StatisticsController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});


    Route::get('/', function () {
    return view('welcome');
});

//     Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

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

// AdminClient Route All
    Route::middleware('auth')->group(function () {
    Route::get('/admin/client/{id}', [AdminClientController::class, 'Index'])->name('admin.index');
    Route::get('/client/report/{id}', [AdminClientController::class, 'ClientReport'])->name('client.report');
});

    Route::prefix('clients/{client_id}')->group(function () {
    Route::get('files', [ClientFileController::class, 'index'])->name('client_files.index');
    Route::get('files/create', [ClientFileController::class, 'create'])->name('client_files.create');
    Route::post('files', [ClientFileController::class, 'store'])->name('client_files.store');
    Route::delete('files/{file}', [ClientFileController::class, 'destroy'])->name('client_files.destroy');
    
});

  
    //Backend Route All

    //บันทึกประวัติผู้รับบริการ
    require __DIR__.'/backend/client.php';

    //บันทึกรายการเอกสาร
    require __DIR__.'/backend/document.php';

    //บันทึกรายการการศึกษา
    require __DIR__.'/backend/education.php';

    //บันทึกประเภทการช่วยเหลือ
    require __DIR__.'/backend/helpType.php';

    //บันทึกประเภทรายได้
    require __DIR__.'/backend/income.php';

    //บันทึกรายชื่อสถานศึกษา
    require __DIR__.'/backend/institution.php';

    //บันทึกรายการพฤติกรรม
    require __DIR__.'/backend/misbehavior.php';

    //บันทึกรายเด็กที่อาศัยอยู่ภายนอก
    require __DIR__.'/backend/outside.php';

    //บันทึกรายการทางจิตเวช
    require __DIR__.'/backend/psycho.php';

    //บันทึกปีการศึกษา
    require __DIR__.'/backend/semester.php';

    //บันทึกรายการวิชา
    require __DIR__.'/backend/subject.php';

    //บันทึกรายการพ้นอุปการะ
    require __DIR__.'/backend/translate.php';




// Frontend Route All
    require __DIR__.'/auth.php';
    // include frontend routes
    
    //บันทึกการขาดเรียน
    require __DIR__.'/frontend/absent.php';

    // บันทึกการบาดเจ็บของเด็ก
     require __DIR__.'/frontend/accident.php';

    // บันทึกการตรวจสารเสพติด
     require __DIR__.'/frontend/addictive.php';

    // บันทึกการติดตามเด็กที่อยู่ภายนอก
     require __DIR__.'/frontend/case_outside.php';

    // บันทึกการตรวจสุขภาพเบื้องต้น
     require __DIR__.'/frontend/checkBody.php';

    // บันทึกการติดตามเด็กในโรงเรียน
     require __DIR__.'/frontend/EducationRecord.php';

    // บันทึกการหลบหนีจากสถานดูแล
     require __DIR__.'/frontend/escape.php';

    // บันทึกการประเมินครอบครัว
     require __DIR__.'/frontend/estimate.php';

    // บันทึกการสอบข้อเท็จจริง
     require __DIR__.'/frontend/factfinding.php';

    // บันทึกข้อมูลบิดา มารดา สามี/ภรรยา และญาติ
     require __DIR__.'/frontend/family.php';

    // บันทึกการเยี่ยมครอบครัว
     require __DIR__.'/frontend/VisitFamily.php';

    // บันทึกการติดตามเด็กที่อาศัยอยู่ภายนอก
     require __DIR__.'/frontend/jobAgency.php';

    // บันทึกการรักษาพยาบาล
     require __DIR__.'/frontend/medical.php';

    // บันทึกสมาชิกในครอบครัว
     require __DIR__.'/frontend/member.php';

    // บันทึกการแก้ไขพฤติกรรม
     require __DIR__.'/frontend/observe.php';

    // บันทึกการตรวจวินิจฉัยทางจิตวิทยา
     require __DIR__.'/frontend/psychiatric.php';

    // บันทึกการจำหน่ายเด็ก
     require __DIR__.'/frontend/refer.php';

    // บันทึกการติดตามการศึกษาเด็ก
     require __DIR__.'/frontend/SchoolFollowup.php';

    // บันทึกประวัติการรับวัคซีน
     require __DIR__.'/frontend/vaccination.php';

    // บันทึกการช่วยเหลือเครื่องอุปโภค/บริโภค
     require __DIR__.'/frontend/HelpSession.php';

















        

           








  











 






    
  




