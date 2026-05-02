<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('client_problem')) {
            Schema::create('client_problem', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('problem_id');
                $table->timestamps();

                $table->primary(['client_id', 'problem_id']);
            });
        }

        Schema::table('client_problem', function (Blueprint $table) {
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->foreign('problem_id')
                ->references('id')
                ->on('problems')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_problem');
    }
};