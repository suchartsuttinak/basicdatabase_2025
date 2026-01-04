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
        Schema::create('images', function (Blueprint $table) {
        $table->id();
        $table->string('file_path');
        $table->string('file_name')->nullable();
        $table->string('mime_type')->nullable();
        $table->unsignedInteger('size')->nullable();

        $table->unsignedBigInteger('visit_family_id')->nullable();
        $table->unsignedBigInteger('client_id')->nullable();

        $table->timestamps();

        $table->foreign('visit_family_id')->references('id')->on('visit_families')->onDelete('cascade');
        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
