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
        Schema::create('visit_families', function (Blueprint $table) {
        $table->id();
        $table->date('visit_date');
        $table->unsignedInteger('count');
        $table->string('family_fname', 100);
        $table->integer('family_age')->nullable();
        $table->string('member', 100)->nullable();

        $table->string('address')->nullable();
        $table->string('moo')->nullable();
        $table->string('soi')->nullable();
        $table->string('road')->nullable();
        $table->string('village')->nullable();

        $table->unsignedBigInteger('province_id')->nullable();
        $table->unsignedBigInteger('district_id')->nullable();
        $table->unsignedBigInteger('sub_district_id')->nullable();
        $table->string('zipcode', 10)->nullable();
        $table->string('phone', 20)->nullable();

        $table->text('outside_address')->nullable();
        $table->text('inside_address')->nullable();
        $table->text('environment')->nullable();
        $table->text('neighbor')->nullable();
        $table->text('member_relation')->nullable();

        $table->unsignedBigInteger('income_id')->nullable();
        $table->text('problem')->nullable();
        $table->text('need')->nullable();
        $table->text('diagnose')->nullable();
        $table->text('assistance')->nullable();
        $table->text('comment')->nullable();
        $table->text('modify')->nullable();

        $table->string('teacher', 100)->nullable();
        $table->text('remark')->nullable();

        $table->unsignedBigInteger('client_id');

        $table->timestamps();

        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        $table->foreign('income_id')->references('id')->on('incomes')->onDelete('set null');
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_families');
    }
};
