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
        Schema::create('observes', function (Blueprint $table) {
            $table->id(); // รหัสบันทึกพฤติกรรม
            $table->date('date'); // วันที่สังเกต
            $table->text('behavior')->nullable(); // ความผิดปกติที่พบเห็น
            $table->text('cause')->nullable(); // สาเหตุ
            $table->text('solution')->nullable(); // แนวทางแก้ไข
            $table->text('action')->nullable(); // การดำเนินการ
            $table->text('obstacles')->nullable(); // ปัญหา/อุปสรรค
            $table->text('result')->nullable(); // ผลลัพธ์
            $table->date('record_date')->nullable(); // วันที่บันทึกผล
            $table->string('recorder', 100)->nullable(); // ผู้ปฏิบัติ

            // Foreign Keys
            $table->unsignedBigInteger('misbehavior_id'); 
            $table->unsignedBigInteger('client_id'); 

            $table->timestamps();

            // กำหนด Foreign Key + Cascade Delete
            $table->foreign('client_id')
                ->references('id')->on('clients')
                ->onDelete('cascade');

            $table->foreign('misbehavior_id')
                ->references('id')->on('misbehaviors');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observes');
    }
};
