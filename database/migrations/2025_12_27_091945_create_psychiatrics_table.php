<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('psychiatrics', function (Blueprint $table) {
    //         $table->id(); // รหัสการตรวจ
    //         $table->date('sent_date'); // วันที่ส่งตรวจ (ห้ามว่าง)
    //         $table->string('hotpital')->nullable(); // สถานพยาบาล
    //         $table->unsignedBigInteger('psycho_id'); // FK ไปยัง psycho (ห้ามว่าง)
    //         $table->text('diagnose')->nullable(); // สรุปผลการตรวจ
    //         $table->date('appoin_date')->nullable(); // นัดครั้งต่อไป
    //         $table->enum('drug_no', ['yes','no'])->default('no'); // รับยา/ไม่รับยา
    //         $table->string('drug_name')->nullable(); // ชื่อยา
    //         $table->enum('disa_no', ['yes','no'])->default('no'); // ขึ้นทะเบียนคนพิการ
    //         $table->unsignedBigInteger('client_id'); // FK ไปยัง clients (ห้ามว่าง)
    //         $table->timestamps();

    //         // Foreign keys
    //         $table->foreign('psycho_id')->references('id')->on('psycho')->onDelete('cascade');
    //         $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychiatrics');
    }
};
