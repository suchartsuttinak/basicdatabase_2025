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
        Schema::create('school_followups', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('client_id');
        $table->unsignedBigInteger('education_record_id');
        $table->date('follow_date');
        $table->string('teacher_name')->nullable();
        $table->string('tel')->nullable();
        $table->string('follow_type'); // self, phone, other
        $table->text('result')->nullable();
        $table->text('remark')->nullable();
        $table->string('contact_name')->nullable();
        $table->timestamps();

        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        $table->foreign('education_record_id')->references('id')->on('education_records')->onDelete('cascade');
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholl_followups');
    }
};
