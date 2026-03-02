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
        Schema::create('relatives', function (Blueprint $table) {
    $table->id();
    $table->string('fname')->nullable();
    $table->string('lname')->nullable();
    $table->integer('age')->nullable();
    $table->string('occupation')->nullable();
    $table->decimal('income', 10, 2)->nullable();
    $table->string('idcard')->nullable();
    $table->string('address_no')->nullable();
    $table->string('moo')->nullable();
    $table->string('soi')->nullable();
    $table->string('road')->nullable();
    $table->string('village')->nullable();

    // One-to-One: client_id ต้องไม่ซ้ำ
    $table->foreignId('client_id')
          ->unique()
          ->constrained('clients')
          ->onDelete('cascade');

    // ที่อยู่
    $table->unsignedBigInteger('province_id')->nullable();   // จังหวัด
    $table->unsignedBigInteger('district_id')->nullable();   // อำเภอ
    $table->unsignedBigInteger('sub_district_id')->nullable(); // ตำบล
    $table->unsignedInteger('zipcode')->nullable();          // รหัสไปรษณีย์
    $table->string('phone', 20)->nullable();                 // เบอร์โทรศัพท์

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatives');
    }
};
