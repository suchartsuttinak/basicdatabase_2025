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
        Schema::create('education_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');       // FK ไปยัง clients
            $table->unsignedBigInteger('education_id');    // ฟิลด์ใหม่ที่คุณต้องการ
            $table->string('semester');                    // เช่น 1/2568
            $table->string('school_name');
            $table->date('record_date');
            $table->timestamps();

            // FK ไปยัง clients
            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->onDelete('cascade');

            // FK ไปยัง education (ถ้ามีตาราง education อยู่แล้ว)
            $table->foreign('education_id')
                  ->references('id')->on('education')
                  ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_records');
    }
};
