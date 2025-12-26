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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id(); // รหัสประวัติการให้วัคซีน
            $table->date('date'); // วันที่
            $table->string('vaccine_name'); // ชนิดของวัคซีนหรือยา
            $table->string('hospital')->nullable(); // สถานพยาบาล
            $table->string('recorder')->nullable(); // ชื่อเจ้าหน้าที่
            $table->text('remark')->nullable(); // หมายเหตุ
            $table->unsignedBigInteger('client_id'); // รหัสผู้รับ

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
