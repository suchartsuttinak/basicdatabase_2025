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
        /*
        |--------------------------------------------------------------------------
        | PATCH: กัน error กรณีตาราง client_problem มีอยู่แล้ว
        |--------------------------------------------------------------------------
        | เดิมใช้ Schema::create() ตรง ๆ ทำให้ error:
        | SQLSTATE[42S01]: Table 'client_problem' already exists
        |--------------------------------------------------------------------------
        */
        if (!Schema::hasTable('client_problem')) {
            Schema::create('client_problem', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('problem_id');
                $table->timestamps();

                $table->primary(['client_id', 'problem_id']);

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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_problem');
    }
};