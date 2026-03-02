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
        Schema::create('escapes', function (Blueprint $table) {
            $table->id(); // รหัสออกจากสถานสงเคราะห์
            $table->date('retire_date'); // วันที่ออก
            $table->unsignedBigInteger('retire_id'); // รหัสประเภทการออกจากหน่วยงาน (FK retires)
            $table->text('stories')->nullable(); // เรื่องราว/สาเหตุ
            $table->unsignedBigInteger('client_id'); // รหัสผู้รับ (FK clients)
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')->on('clients')
                ->onDelete('cascade'); // ลบ client → ลบ escapes

            $table->foreign('retire_id')
                ->references('id')->on('retires'); // สมมติ retires มีอยู่แล้ว
        });


        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escapes');
    }
};
