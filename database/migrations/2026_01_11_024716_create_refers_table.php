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
        Schema::create('refers', function (Blueprint $table) {
             $table->id(); // id
            $table->date('refer_date'); // วันที่นำส่ง
            $table->unsignedBigInteger('translate_id'); // รหัสสาเหตุที่จำหน่าย
            $table->string('destination')->nullable(); // ชื่อสถานที่นำส่ง
            $table->string('address')->nullable(); // ที่อยู่
            $table->enum('guardian', ['มี', 'ไม่มี']); // ผู้ดูแล
            $table->string('parent_name')->nullable(); // ชื่อผู้รับตัว
            $table->string('parent_tel')->nullable(); // โทรศัพท์
            $table->string('member')->nullable(); // ความสัมพันธ์
            $table->string('teacher')->nullable(); // ชื่อผู้นำส่ง
            $table->text('remark')->nullable(); // หมายเหตุ
            $table->unsignedBigInteger('client_id'); // รหัสผู้รับ
            $table->timestamps();

            // FK
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('translate_id')->references('id')->on('translates')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refers');
    }
};
