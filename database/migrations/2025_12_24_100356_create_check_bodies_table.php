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
        Schema::create('check_bodies', function (Blueprint $table) {
            $table->id(); // id
            $table->date('assessor_date')->nullable(); // วันที่ตรวจ
            $table->enum('development', ['สมวัย', 'ไม่สมวัย'])->default('สมวัย'); // ค่าเริ่มต้น
            $table->text('detail')->nullable(); // รายละเอียด (กรณีไม่สมวัย)
            $table->decimal('weight', 5, 2)->nullable(); // น้ำหนัก
            $table->decimal('height', 5, 2)->nullable(); // ส่วนสูง
            $table->string('oral')->nullable(); // สุขภาพช่องปาก
            $table->string('appearance')->nullable(); // รูปร่าง / ลักษณะ
            $table->string('wound')->nullable(); // ร่องรอย บาดแผล
            $table->string('disease')->nullable(); // โรคประจำตัว
            $table->string('hygiene')->nullable(); // สุขภาพอนามัย
            $table->string('health')->nullable(); // สุขภาพ
            $table->string('inoculation')->nullable(); // การปลูกฝี
            $table->string('injection')->nullable(); // การฉีดยา
            $table->string('vaccination')->nullable(); // การให้วัคซีน
            $table->string('contagious')->nullable(); // โรคติดต่อ
            $table->string('other')->nullable(); // การเจ็บป่วยอื่นๆ
            $table->string('drug_allergy')->nullable(); // ประวัติการแพ้ยา
            $table->string('recorder')->nullable(); // ผู้ตรวจ
            $table->text('remark')->nullable(); // หมายเหตุ

            $table->unsignedBigInteger('client_id'); // FK
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->timestamps();
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_bodies');
    }
};
