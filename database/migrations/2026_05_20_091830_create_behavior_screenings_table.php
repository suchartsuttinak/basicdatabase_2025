<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('behavior_screenings', function (Blueprint $table) {
            $table->id();

            // เชื่อมกับเด็ก/ผู้รับบริการ
            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            // ผู้บันทึกข้อมูล
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // ข้อมูลหัวแบบประเมิน
            $table->date('screening_date');
            $table->string('observer_name')->nullable();
            $table->string('age_text')->nullable();
            $table->string('class_level')->nullable();

            // คะแนนรวมแต่ละด้าน
            $table->unsignedTinyInteger('learning_score')->default(0);
            $table->unsignedTinyInteger('ld_score')->default(0);
            $table->unsignedTinyInteger('adhd_score')->default(0);
            $table->unsignedTinyInteger('autism_score')->default(0);

            // ผลความเสี่ยง
            $table->boolean('learning_risk')->default(false);
            $table->boolean('ld_risk')->default(false);
            $table->boolean('adhd_risk')->default(false);
            $table->boolean('autism_risk')->default(false);

            // สรุปผลและคำแนะนำ
            $table->text('summary')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('remark')->nullable();

            $table->timestamps();

            $table->index(['client_id', 'screening_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('behavior_screenings');
    }
};