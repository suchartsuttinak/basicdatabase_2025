<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estimates', function (Blueprint $table) {
            if (!Schema::hasColumn('estimates', 'family_income')) {
                $table->decimal('family_income', 10, 2)->nullable()->after('results');
            }

            if (!Schema::hasColumn('estimates', 'guardian_job')) {
                $table->string('guardian_job', 255)->nullable()->after('family_income');
            }

            if (!Schema::hasColumn('estimates', 'income_sufficiency')) {
                $table->string('income_sufficiency', 50)->nullable()->after('guardian_job');
            }

            if (!Schema::hasColumn('estimates', 'income_reason')) {
                $table->text('income_reason')->nullable()->after('income_sufficiency');
            }

            if (!Schema::hasColumn('estimates', 'debt')) {
                $table->decimal('debt', 10, 2)->nullable()->after('income_reason');
            }

            if (!Schema::hasColumn('estimates', 'housing_condition')) {
                $table->string('housing_condition', 255)->nullable()->after('debt');
            }
        });
    }

    public function down(): void
    {
        Schema::table('estimates', function (Blueprint $table) {
            if (Schema::hasColumn('estimates', 'housing_condition')) {
                $table->dropColumn('housing_condition');
            }

            if (Schema::hasColumn('estimates', 'debt')) {
                $table->dropColumn('debt');
            }

            if (Schema::hasColumn('estimates', 'income_reason')) {
                $table->dropColumn('income_reason');
            }

            if (Schema::hasColumn('estimates', 'income_sufficiency')) {
                $table->dropColumn('income_sufficiency');
            }

            if (Schema::hasColumn('estimates', 'guardian_job')) {
                $table->dropColumn('guardian_job');
            }

            if (Schema::hasColumn('estimates', 'family_income')) {
                $table->dropColumn('family_income');
            }
        });
    }
};