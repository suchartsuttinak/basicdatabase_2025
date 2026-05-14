<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('refers') && !Schema::hasColumn('refers', 'committee_result')) {
            Schema::table('refers', function (Blueprint $table) {
                $table->string('committee_result')->nullable()->after('teacher');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('refers') && Schema::hasColumn('refers', 'committee_result')) {
            Schema::table('refers', function (Blueprint $table) {
                $table->dropColumn('committee_result');
            });
        }
    }
};