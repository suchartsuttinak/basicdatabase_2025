<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('case_activities')) {
            Schema::create('case_activities', function (Blueprint $table) {
                $table->id();

                $table->foreignId('client_id')
                    ->constrained('clients')
                    ->cascadeOnDelete();

                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->string('module')->nullable(); 
                // เช่น medical, absent, refer, transfer

                $table->string('type')->default('info');
                // info, success, warning, danger

                $table->string('title');
                // หัวข้อ เช่น บันทึกข้อมูลสุขภาพ

                $table->text('description')->nullable();
                // รายละเอียดเพิ่มเติม

                $table->dateTime('occurred_at')->nullable();
                // วันที่เกิดเหตุการณ์จริง

                $table->string('icon')->nullable();
                // เช่น bi-heart-pulse, bi-calendar-check

                $table->string('url')->nullable();
                // ลิงก์กลับไปหน้ารายการต้นทาง ถ้ามี

                $table->timestamps();

                $table->index(['client_id', 'occurred_at']);
                $table->index(['module', 'type']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('case_activities');
    }
};