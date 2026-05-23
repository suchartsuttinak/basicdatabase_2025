<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('behavior_screening_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('behavior_screening_id')
                ->constrained('behavior_screenings')
                ->cascadeOnDelete();

            // หมวด: learning, ld, adhd, autism
            $table->string('category', 30);

            // เลขข้อ
            $table->unsignedTinyInteger('item_no');

            // ข้อคำถาม
            $table->text('question');

            // ใช่ = 1, ไม่ใช่ = 0
            $table->boolean('answer')->default(false);

            $table->timestamps();

            $table->index(['behavior_screening_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('behavior_screening_items');
    }
};