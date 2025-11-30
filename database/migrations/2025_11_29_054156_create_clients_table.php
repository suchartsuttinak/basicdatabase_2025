<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
           $table->bigIncrements('id'); // รหัสผู้รับ
            $table->string('register_number')->nullable(); // เลขทะเบียนแฟ้มประวัติ
            $table->unsignedBigInteger('title_id'); // คํานําหน้า
            $table->string('nick_name')->nullable(); // ชื่อเล่น
            $table->string('first_name'); // ชื่อ
            $table->string('last_name'); // นามสกุล
            $table->string('gender', 10)->default('male');// เพศ
            $table->date('birth_date')->nullable(); // วัน เดือน ปีเกิด
            $table->string('id_card', 13)->nullable(); // เลขประจำตัวประชาชน

            $table->unsignedBigInteger('national_id'); // สัญชาติ
            $table->unsignedBigInteger('ligion_id'); // ศาสนา
            $table->unsignedBigInteger('marital_id'); // สถานะภาพการสมรส
            $table->unsignedBigInteger('occupation_id'); // อาชีพ
            $table->unsignedBigInteger('income_id')->nullable(); // รายได้เฉลี่ย
            $table->unsignedBigInteger('education_id'); // ระดับการศึกษา
            $table->string('scholl')->nullable(); // โรงเรียน

            $table->string('address')->nullable(); // ที่อยู่ปัจจุบัน
            $table->string('moo')->nullable(); // หมู่
            $table->string('soi')->nullable(); // ซอย
            $table->string('road')->nullable(); // ถนน
            $table->string('village')->nullable(); // ซอย
            $table->unsignedBigInteger('province_id')->nullable(); // จังหวัด
            $table->unsignedBigInteger('district_id')->nullable(); // อำเภอ
            $table->unsignedBigInteger('sub_disdrict_id')->nullable(); // ตำบล
            $table->unsignedInteger('zipcode')->nullable(); // รหัสไปรษณีย์
            $table->string('phone', 50)->nullable(); // เบอร์โทรศัพท์
            $table->date('arrival_date'); // วันที่รับเข้า

            $table->unsignedBigInteger('target_id'); // กลุ่มเป้าหมาย
            $table->unsignedBigInteger('contact_id'); // วิธีการติดต่อ
            $table->unsignedBigInteger('project_id'); // หน่วยงาน
            $table->unsignedBigInteger('house_id')->nullable(); // รหัสบ้าน

            $table->unsignedBigInteger('status_id'); // สถานะผู้เข้ารับ

            $table->string('case_resident')->default('Active');
            
            $table->string('image')->nullable(); // รูปภาพ

            // $table->enum('case_resident', ['Active', 'Not Active'])->default('Active'); // สถานะการอยู่อาศัย

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
