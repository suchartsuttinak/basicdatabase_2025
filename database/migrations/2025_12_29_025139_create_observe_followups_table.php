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
         Schema::create('observe_followups', function (Blueprint $table) {
        $table->id(); // รหัสติดตามผล
        $table->unsignedBigInteger('observe_id'); // FK ไปยัง observes
        $table->date('followup_date'); // วันที่ติดตามผล
        $table->integer('followup_count'); // ครั้งที่ติดตามผล
        $table->text('followup_action')->nullable(); // การดำเนินงาน
        $table->text('followup_result')->nullable(); // ผลลัพธ์
        $table->timestamps();

        // Cascade Delete เมื่อ observe ถูกลบ
        $table->foreign('observe_id')
              ->references('id')->on('observes')
              ->onDelete('cascade');




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observe_followups');
    }
};
