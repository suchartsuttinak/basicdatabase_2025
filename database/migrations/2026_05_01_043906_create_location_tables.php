<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('provinces')) {
            Schema::create('provinces', function (Blueprint $table) {
                $table->id();
                $table->string('prov_code')->nullable();
                $table->string('prov_name');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('districts')) {
            Schema::create('districts', function (Blueprint $table) {
                $table->id();
                $table->string('dist_code')->nullable();
                $table->unsignedBigInteger('province_id');
                $table->string('dist_name');
                $table->timestamps();

                $table->foreign('province_id')
                    ->references('id')
                    ->on('provinces')
                    ->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('sub_districts')) {
            Schema::create('sub_districts', function (Blueprint $table) {
                $table->id();
                $table->string('subd_code')->nullable(); // ✅ ให้ตรง SQL
                $table->unsignedBigInteger('district_id');
                $table->string('subd_name'); // ✅ ให้ตรง SQL
                $table->string('zipcode', 10)->nullable(); // ✅ ให้ตรง SQL
                $table->timestamps();

                $table->foreign('district_id')
                    ->references('id')
                    ->on('districts')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_districts');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
    }
};