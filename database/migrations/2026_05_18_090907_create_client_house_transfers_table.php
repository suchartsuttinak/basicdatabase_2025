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
       Schema::create('client_house_transfers', function (Blueprint $table) {
    $table->id();

    $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

    $table->unsignedBigInteger('old_house_id')->nullable();
    $table->unsignedBigInteger('new_house_id');

    $table->unsignedBigInteger('project_id')->nullable();

    $table->unsignedBigInteger('caregiver_id')->nullable();
    $table->unsignedBigInteger('changed_by')->nullable();

    $table->date('transfer_date')->nullable();
    $table->text('remark')->nullable();

    $table->timestamps();

    $table->foreign('old_house_id')->references('id')->on('houses')->nullOnDelete();
    $table->foreign('new_house_id')->references('id')->on('houses')->cascadeOnDelete();
    $table->foreign('project_id')->references('id')->on('projects')->nullOnDelete();
    $table->foreign('caregiver_id')->references('id')->on('users')->nullOnDelete();
    $table->foreign('changed_by')->references('id')->on('users')->nullOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_house_transfers');
    }
};
