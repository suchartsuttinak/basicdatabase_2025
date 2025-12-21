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
        Schema::create('absents', function (Blueprint $table) {
            $table->id();
            $table->date('absent_date')->comment('วันที่ขาดเรียน');
            $table->text('cause')->nullable()->comment('สาเหตุที่ขาดเรียน');
            $table->text('operation')->nullable()->comment('การดำเนินการ');
            $table->text('remark')->nullable()->comment('หมายเหตุ');
            $table->date('record_date')->comment('วันที่บันทึก');
            $table->string('teacher')->nullable()->comment('ชื่อครูผู้ให้ข้อมูล');

            // ✅ Foreign keys
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->onDelete('cascade');

            $table->foreignId('education_record_id')
                  ->nullable()
                  ->constrained('education_records')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absents');
    }
};
