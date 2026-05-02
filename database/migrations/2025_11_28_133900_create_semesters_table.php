<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('semesters')) {
            Schema::create('semesters', function (Blueprint $table) {
                $table->id();
                $table->string('semester_name')->nullable(); // เช่น 1/2568
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};