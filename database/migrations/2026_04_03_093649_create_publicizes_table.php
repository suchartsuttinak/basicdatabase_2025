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
        Schema::create('publicizes', function (Blueprint $table) {
            $table->id();
            $table->date('recorded_at')->comment('วันที่บันทึก');
            $table->string('category', 50)->comment('ประเภทข้อมูล');
            $table->string('title')->comment('ชื่อเรื่อง');
            $table->string('file_path')->comment('path ไฟล์ pdf');
            $table->string('file_name')->nullable()->comment('ชื่อไฟล์เดิม');
            $table->timestamps();

            $table->index('category');
            $table->index('recorded_at');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicizes');
    }
};
