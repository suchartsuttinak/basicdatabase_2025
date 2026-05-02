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
       Schema::create('scholarship_donations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('scholarship_id')
        ->constrained('scholarships')
        ->cascadeOnDelete();

        $table->date('donation_date')->nullable();
        $table->decimal('amount', 10, 2)->nullable();
        $table->string('donation_type')->nullable(); // เงินสด / โอน / สิ่งของ
        $table->text('description')->nullable();
        $table->string('recorded_by')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarship_donations');
    }
};
