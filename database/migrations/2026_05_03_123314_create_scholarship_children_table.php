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
     Schema::create('scholarship_children', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedTinyInteger('age')->nullable();

            $table->string('education_level')->nullable(); // ระดับการศึกษา
            $table->string('school_name')->nullable();
            $table->string('academic_year'); // ปีการศึกษาที่ขอรับทุน เช่น 2568

            $table->text('current_address')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('phone', 30)->nullable();

            $table->text('reason')->nullable(); // สาเหตุที่ขอรับทุน
            $table->text('help_needed')->nullable(); // ความต้องการช่วยเหลือ
            $table->text('more_detail')->nullable();

            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_children');
    }
};
