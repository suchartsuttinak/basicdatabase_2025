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
        Schema::create('job_agencies', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->date('job_date'); // วันที่เริ่มงาน
            $table->string('position'); // ตำแหน่ง
            $table->decimal('income', 10, 2); // รายได้ (บาท/เดือน)
            $table->string('company'); // บริษัท/หน่วยงาน
            $table->string('coordinator'); // ผู้ประสานงาน
            $table->text('remark')->nullable(); // หมายเหตุ

            // Foreign key เชื่อมกับ clients
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->onDelete('cascade'); // ถ้าลบ client จะลบ job_agency ด้วย

            // Foreign key เชื่อมกับ occupations (เลือกอาชีพเดียว)
            $table->unsignedBigInteger('occupation_id');
            $table->foreign('occupation_id')
                  ->references('id')->on('occupations')
                  ->onDelete('restrict'); // ป้องกันการลบ occupation ที่ถูกใช้งาน

            // สำหรับการเรียงลำดับ count
            $table->unsignedInteger('count')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('job_agencies');
    }
};

