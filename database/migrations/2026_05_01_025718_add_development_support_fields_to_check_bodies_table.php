<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('check_bodies', function (Blueprint $table) {
            if (!Schema::hasColumn('check_bodies', 'development_type')) {
                $table->string('development_type')->nullable()->after('detail');
            }

            if (!Schema::hasColumn('check_bodies', 'special_support_type')) {
                $table->string('special_support_type')->nullable()->after('development_type');
            }

            if (!Schema::hasColumn('check_bodies', 'special_support_other')) {
                $table->string('special_support_other')->nullable()->after('special_support_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('check_bodies', function (Blueprint $table) {
            if (Schema::hasColumn('check_bodies', 'special_support_other')) {
                $table->dropColumn('special_support_other');
            }

            if (Schema::hasColumn('check_bodies', 'special_support_type')) {
                $table->dropColumn('special_support_type');
            }

            if (Schema::hasColumn('check_bodies', 'development_type')) {
                $table->dropColumn('development_type');
            }
        });
    }
};