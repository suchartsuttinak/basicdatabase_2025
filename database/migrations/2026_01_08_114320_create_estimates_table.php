<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->unsignedInteger('count')->default(1);

            $table->enum('follo_no', [
                'หน่วยงานไปเอง',
                'โทรศัพท์',
                'จดหมาย'
            ]);

            $table->text('results')->nullable();

            /*
            |-------------------------------------------
            | ฐานะทางเศรษฐกิจครอบครัว
            |-------------------------------------------
            */
            $table->decimal('family_income', 10, 2)->nullable(); // รายได้ครอบครัว
            $table->string('guardian_job', 255)->nullable(); // อาชีพผู้ปกครอง
            $table->string('income_sufficiency', 50)->nullable(); // เพียงพอ/ไม่เพียงพอ
            $table->text('income_reason')->nullable(); // เหตุผลรายได้ไม่พอ

            // ✅ แก้จาก decimal เป็น text เพราะใช้เก็บรายละเอียดหนี้สินเป็นข้อความ
            $table->text('debt')->nullable(); // รายละเอียดหนี้สิน

            $table->string('housing_condition', 255)->nullable(); // สภาพที่อยู่อาศัย

            $table->string('teacher')->nullable(); // ผู้ประเมิน
            $table->text('remark')->nullable(); // หมายเหตุ

            $table->foreignId('client_id')
                ->constrained('clients')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};