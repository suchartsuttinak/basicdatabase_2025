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
        Schema::create('members', function (Blueprint $table) {
             $table->id(); // auto_increment primary key
    $table->unsignedBigInteger('client_id'); // FK to clients
    $table->integer('count')->nullable(); // ลำดับที่ (ไม่ auto_increment)
    $table->string('fullname');
    $table->integer('member_age')->nullable();
    $table->unsignedBigInteger('education_id')->nullable();
    $table->string('relationship')->nullable();
    $table->unsignedBigInteger('occupation_id')->nullable();
    $table->unsignedBigInteger('income_id')->nullable();
    $table->text('remark')->nullable();
    $table->timestamps();

    // Foreign keys
    $table->foreign('client_id')
          ->references('id')->on('clients')
          ->onDelete('cascade');

    $table->foreign('education_id')->references('id')->on('education');
    $table->foreign('occupation_id')->references('id')->on('occupations');
    $table->foreign('income_id')->references('id')->on('incomes');


        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
