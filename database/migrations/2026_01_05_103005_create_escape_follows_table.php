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
        Schema::create('escape_follows', function (Blueprint $table) {
            $table->id(); // รหัสการติดตาม
            $table->unsignedBigInteger('escape_id'); // รหัสการออกสถานสงเคราะห์ (FK escapes)
            $table->date('trace_date'); // วันที่ติดตาม
            $table->integer('count'); // ครั้งที่ติดตาม (นับอัตโนมัติภายใน escape เดียว)
            $table->enum('trac_no', ['พบ', 'ไม่พบ']); // พบ/ไม่พบ
            $table->text('detail')->nullable(); // รายละเอียดเพิ่มเติม (พบเท่านั้น)
            $table->date('report_date')->nullable(); // วันที่แจ้งความ
            $table->date('stop_date')->nullable(); // วันที่ยุติการติดตาม
            $table->string('punish')->nullable(); // การลงโทษ
            $table->date('punish_date')->nullable(); // วันที่ลงโทษ
            $table->string('remark')->nullable(); // หมายเหตุ
            $table->timestamps();

            $table->foreign('escape_id')
                ->references('id')->on('escapes')
                ->onDelete('cascade'); // ลบ escape → ลบ follows


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escape_follows');
    }
};
