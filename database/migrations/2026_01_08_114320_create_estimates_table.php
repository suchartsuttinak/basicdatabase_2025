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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // วันที่ติดตาม
            $table->unsignedInteger('count')->default(1); // ครั้งที่ (auto count)
            $table->enum('follo_no', ['หน่วยงานไปเอง','โทรศัพท์','จดหมาย']); // การดำเนินงาน
            $table->text('results')->nullable(); // ผลการติดตาม
            $table->string('teacher')->nullable(); // ผู้ประเมิน
            $table->text('remark')->nullable(); // หมายเหตุ
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // FK ไป clients
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
