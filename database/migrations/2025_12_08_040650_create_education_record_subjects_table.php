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
        Schema::create('education_record_subjects', function (Blueprint $table) {
              $table->id();
            $table->unsignedBigInteger('education_record_id');
            $table->unsignedBigInteger('subject_id');
            $table->integer('score')->nullable();
            $table->string('grade')->nullable();
            $table->timestamps();

            // FK ไปยัง education_records
            $table->foreign('education_record_id')
                  ->references('id')->on('education_records')
                  ->onDelete('cascade');

            // FK ไปยัง subjects
            $table->foreign('subject_id')
                  ->references('id')->on('subjects')
                  ->onDelete('cascade');

            // ป้องกันไม่ให้เลือกวิชาเดิมซ้ำในภาคเรียนเดียวกัน
            $table->unique(['education_record_id', 'subject_id']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_record_subjects');
    }
};
