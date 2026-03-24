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
    Schema::create('issues', function (Blueprint $table) {
        $table->id();
        $table->string('fullname');   // ชื่อ-สกุลผู้แจ้ง
        $table->string('phone', 20);  // เบอร์โทรศัพท์
        $table->text('subject');      // เรื่องที่แจ้ง
        $table->timestamps();         // created_at, updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
