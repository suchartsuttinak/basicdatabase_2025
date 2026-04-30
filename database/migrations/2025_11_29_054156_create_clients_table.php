<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('register_number')->nullable();

            $table->unsignedBigInteger('title_id');

            $table->string('nick_name')->nullable();

            $table->string('first_name');
            $table->string('last_name');

            $table->string('gender',10)->default('male');

            $table->date('birth_date')->nullable();

            /*
            |--------------------------------------------------------------------------
            | ปรับจาก 13 เป็น 17 รองรับรูปแบบ 0-0000-00000-00-0
            |--------------------------------------------------------------------------
            */
            $table->string('id_card',17)->nullable();

            $table->unsignedBigInteger('national_id');
            $table->unsignedBigInteger('ligion_id');
            $table->unsignedBigInteger('marital_id');
            $table->unsignedBigInteger('occupation_id');
            $table->unsignedBigInteger('income_id')->nullable();
            $table->unsignedBigInteger('education_id');

            $table->string('scholl')->nullable();

            $table->string('address')->nullable();
            $table->string('moo')->nullable();
            $table->string('soi')->nullable();
            $table->string('road')->nullable();
            $table->string('village')->nullable();

            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('sub_disdrict_id')->nullable();

            $table->unsignedInteger('zipcode')->nullable();

            $table->string('phone',50)->nullable();

            $table->date('arrival_date');

            $table->unsignedBigInteger('target_id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('project_id');

            $table->unsignedBigInteger('house_id')->nullable();

            $table->unsignedBigInteger('status_id');

            $table->string('case_resident')->default('Active');

            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};