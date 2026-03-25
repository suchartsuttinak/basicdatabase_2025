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
        Schema::create('about_data', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['history', 'objective', 'mission']); // ประเภทข้อมูล
            $table->text('content'); // เนื้อหาที่กรอก
            $table->timestamps(); // created_at, updated_at


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_data');
    }
};
