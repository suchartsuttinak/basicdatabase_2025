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
        Schema::create('accidents', function (Blueprint $table) {
          $table->id(); // รหัสบันทึกการประสบอุบัติเหตุ
        $table->date('incident_date'); // วันที่เกิดเหตุการณ์
        $table->string('location')->nullable(); // สถานที่เกิดเหตุการณ์
        $table->string('eyewitness')->nullable(); // ผู้เห็นเหตุการณ์
        $table->text('detail')->nullable(); // รายละเอียดเหตุการณ์
        $table->string('cause')->nullable(); // สาเหตุ
        $table->enum('treat_no', ['พบแพทย์', 'ไม่พบแพทย์'])->default('ไม่พบแพทย์'); // รหัสการรักษาพยาบาล
        $table->string('hospital')->nullable(); // ชื่อสถานพยาบาล
        $table->text('diagnosis')->nullable(); // การวินิจฉัย
        $table->string('appointment')->nullable(); // นัดครั้งต่อไป
        $table->text('protection')->nullable(); // การแก้ไขและป้องกัน
        $table->text('treatment')->nullable(); // การรักษา
        $table->string('caretaker')->nullable(); // ผู้ดูแล
        $table->date('record_date'); // วันที่บันทึก

        // FK ไปยัง clients
        $table->foreignId('client_id')
              ->constrained('clients')
              ->onDelete('cascade');

        $table->timestamps();

        // Indexes
        $table->index('incident_date');
        $table->index('client_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accidents');
    }
};
