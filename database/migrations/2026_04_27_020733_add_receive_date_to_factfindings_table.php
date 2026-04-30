<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factfindings', function (Blueprint $table) {
            if (!Schema::hasColumn('factfindings', 'blood_group')) {
                $table->string('blood_group')->nullable()->after('height');
            }

            if (!Schema::hasColumn('factfindings', 'hygiene')) {
                $table->string('hygiene')->nullable()->after('blood_group');
            }

            if (!Schema::hasColumn('factfindings', 'oral_health')) {
                $table->string('oral_health')->nullable()->after('hygiene');
            }

            if (!Schema::hasColumn('factfindings', 'injury')) {
                $table->string('injury')->nullable()->after('oral_health');
            }
        });
    }

    public function down(): void
    {
        Schema::table('factfindings', function (Blueprint $table) {
            if (Schema::hasColumn('factfindings', 'injury')) {
                $table->dropColumn('injury');
            }

            if (Schema::hasColumn('factfindings', 'oral_health')) {
                $table->dropColumn('oral_health');
            }

            if (Schema::hasColumn('factfindings', 'hygiene')) {
                $table->dropColumn('hygiene');
            }

            if (Schema::hasColumn('factfindings', 'blood_group')) {
                $table->dropColumn('blood_group');
            }
        });
    }
};