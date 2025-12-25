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
        Schema::create('medicals', function (Blueprint $table) {
            $table->id(); // id
            $table->date('medical_date'); // วันที่ (ห้ามว่าง)
            $table->string('disease_name')->nullable(); // ชื่อโรค
            $table->text('illness')->nullable(); // อาการป่วย
            $table->text('treatment')->nullable(); // การรักษา/การปฐมพยาบาล
            $table->enum('refer', ['พบแพทย์', 'ไม่พบแพทย์'])->default('ไม่พบแพทย์'); // พบแพทย์/ไม่พบแพทย์
            $table->text('diagnosis')->nullable(); // การรักษา
            $table->date('appt_date')->nullable(); // วันที่แพทย์นัด
            $table->string('teacher')->nullable(); // ผู้ดูแล
            $table->text('remark')->nullable(); // หมายเหตุ
            $table->unsignedBigInteger('client_id'); // รหัสผู้รับ

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicals');
    }
};
