<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // กันสร้างซ้ำ
            if (!Schema::hasColumn('users', 'project_id')) {

                $table->unsignedBigInteger('project_id')
                    ->nullable()
                    ->after('status');

                $table->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'project_id')) {

                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            }
        });
    }
};