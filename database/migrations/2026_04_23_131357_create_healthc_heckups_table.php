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
        Schema::create('healthc_heckups', function (Blueprint $table) {
            $table->id();

            // ✅ ผูกกับ clients และถ้าลบ client ให้ลบ healthc_heckups ตาม
            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            // 1) วันที่ตรวจ
            $table->date('checkup_date');

            // 2) สถานพยาบาล
            $table->string('hospital_name', 255);

            // 3) ผลการตรวจ
            $table->enum('checkup_result', ['normal', 'abnormal'])->default('normal');
            $table->text('abnormal_detail')->nullable();

            // 4) เอกสารทางการแพทย์ pdf
            $table->string('medical_document')->nullable();

            // 5) ผู้บันทึก
            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['client_id', 'checkup_date']);
            $table->index('checkup_result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('healthc_heckups');
    }
};