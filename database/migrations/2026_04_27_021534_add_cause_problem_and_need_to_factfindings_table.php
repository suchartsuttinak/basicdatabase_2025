<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factfindings', function (Blueprint $table) {
            if (!Schema::hasColumn('factfindings', 'cause_problem')) {
                $table->text('cause_problem')->nullable()->after('environment');
            }

            if (!Schema::hasColumn('factfindings', 'need')) {
                $table->text('need')->nullable()->after('cause_problem');
            }
        });
    }

    public function down(): void
    {
        Schema::table('factfindings', function (Blueprint $table) {
            if (Schema::hasColumn('factfindings', 'need')) {
                $table->dropColumn('need');
            }

            if (Schema::hasColumn('factfindings', 'cause_problem')) {
                $table->dropColumn('cause_problem');
            }
        });
    }
};