<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\backend\OperationController;
use App\Http\Controllers\backend\PublicizeController;
use App\Http\Controllers\ClientAdmin\AdminClientController;
use App\Http\Controllers\Landing\AboutController;
use App\Http\Controllers\Landing\IssueController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Landing\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;





// ประมวลผล/สถิติ หน้า dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StatisticsController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});



Route::post('/issues', [IssueController::class, 'store'])->name('issues.store');

// Landing Issue donation

Route::middleware('auth')->group(function () {
Route::get('/issues', [IssueController::class, 'index'])->name('issues.index');

});


// หน้า Landing
Route::get('/', [LandingController::class, 'index'])->name('landing.index');

// หน้า News CRUD
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');





// หน้า about (ฟอร์มกรอกข้อมูล history, objective, mission, contact)
Route::get('/about', [AboutController::class, 'index'])->name('landing.about.index');
Route::post('/about', [AboutController::class, 'store'])->name('landing.about.store');
Route::delete('/about/{id}', [AboutController::class, 'destroy'])->name('landing.about.delete');



// หน้า publicizes (ฟอร์มกรอกข้อมูลข่าวสาร/กิจกรรม)
   Route::prefix('publicizes')->group(function () {
    Route::get('/', [PublicizeController::class, 'index'])->name('publicizes.index');
    Route::get('/create', [PublicizeController::class, 'create'])->name('publicizes.create');
    Route::post('/store', [PublicizeController::class, 'store'])->name('publicizes.store');
    Route::get('/edit/{publicize}', [PublicizeController::class, 'edit'])->name('publicizes.edit');
    Route::put('/update/{publicize}', [PublicizeController::class, 'update'])->name('publicizes.update');
    Route::delete('/delete/{publicize}', [PublicizeController::class, 'destroy'])->name('publicizes.destroy');
});

   

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
    Route::get('/admin/client/{id}', [AdminClientController::class, 'Index'])
        ->whereNumber('id')
        ->name('admin.index');

    Route::get('/client/report/{id}', [AdminClientController::class, 'ClientReport'])
        ->whereNumber('id')
        ->name('client.report');
});


// User Management (Admin Only)
    Route::prefix('admin/users')->middleware(['auth', 'role:admin', 'prevent-back'])->group(function () {
    Route::get('/', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/store', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/update/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/delete/{id}', [UserManagementController::class, 'destroy'])->name('users.delete');
    Route::post('/toggle-status/{id}', [UserManagementController::class, 'toggleStatus'])->name('users.toggleStatus');
});



    // Operation Route All
        Route::middleware(['auth'])->prefix('operations')->group(function () {
        Route::get('/', [OperationController::class, 'index'])->name('operations.index');
        Route::get('/create', [OperationController::class, 'create'])->name('operations.create');
        Route::post('/store', [OperationController::class, 'store'])->name('operations.store');
        Route::get('/edit/{id}', [OperationController::class, 'edit'])->name('operations.edit');
        Route::put('/update/{id}', [OperationController::class, 'update'])->name('operations.update');
        Route::delete('/delete/{id}', [OperationController::class, 'destroy'])->name('operations.delete');

        // รายงานรายวัน
        Route::get('/report/daily', [OperationController::class, 'dailyReport'])->name('operations.report.daily');
    });

    // User Route All
   

    Route::middleware(['auth', 'role:admin'])->prefix('admin/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');

    Route::patch('/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
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

     // บันทึกรายการเอกสาร
      require __DIR__.'/frontend/client_files.php';


    // ===== ติดตามผล =====
      require __DIR__.'/frontend/followup.php';
















        

           








  











 






    
  




