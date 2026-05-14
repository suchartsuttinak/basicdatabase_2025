<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('psychiatrics')) {
            Schema::create('psychiatrics', function (Blueprint $table) {
                $table->id();

                $table->date('sent_date')->nullable();
                $table->string('hotpital')->nullable();
                $table->unsignedBigInteger('psycho_id')->nullable();
                $table->text('diagnose')->nullable();
                $table->date('appoin_date')->nullable();
                $table->string('drug_no')->nullable();
                $table->string('drug_name')->nullable();
                $table->string('disa_no')->nullable();

                $table->unsignedBigInteger('client_id');
                $table->timestamps();

                $table->foreign('psycho_id')
                    ->references('id')
                    ->on('psychos')
                    ->nullOnDelete();

                $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('psychiatrics');
    }
};