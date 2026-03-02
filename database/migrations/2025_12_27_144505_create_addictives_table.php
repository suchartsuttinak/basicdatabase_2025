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
        Schema::create('addictives', function (Blueprint $table) {
            $table->id(); // id
            $table->date('date'); // วันที่ตรวจ
            $table->integer('count'); // ครั้งที่
            $table->tinyInteger('exam')->default(0); 
            // 0 = ไม่พบสารเสพติด, 1 = พบสารเสพติด
            $table->tinyInteger('refer')->nullable(); 
            // 1 = ส่งต่อบำบัด, 2 = ติดตามดูแลต่อเนื่อง
            $table->text('record')->nullable(); // บันทึกผล
            $table->string('recorder'); // ผู้ตรวจ
            $table->unsignedBigInteger('client_id'); // FK ไปยัง clients
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addictives');
    }
};
