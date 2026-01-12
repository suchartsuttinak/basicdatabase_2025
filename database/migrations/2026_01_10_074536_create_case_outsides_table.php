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
        Schema::create('case_outsides', function (Blueprint $table) {
        $table->id(); // id
        $table->date('date'); // วันที่ติดตาม
        $table->integer('count'); // ครั้งที่ (auto increment ตามวันที่)
        $table->unsignedBigInteger('outside_id'); // FK -> outside
        $table->string('dormitory')->nullable(); // สถานที่พักอาศัย
        $table->enum('follo_no', ['หน่วยงานไปเอง','โทรศัพท์','จดหมาย']); // radio button
        $table->text('results')->nullable(); // ผลการติดตาม
        $table->string('teacher')->nullable(); // ผู้ติดตาม
        $table->text('remerk')->nullable(); // หมายเหตุ
        $table->unsignedBigInteger('client_id'); // FK -> clients
        $table->timestamps();

        // FK
        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        $table->foreign('outside_id')->references('id')->on('outsides')->onDelete('cascade');

        // unique date per client
        $table->unique(['client_id','date']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_outsides');
    }
};
