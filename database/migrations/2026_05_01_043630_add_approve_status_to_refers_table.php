<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('refers', function (Blueprint $table) {
            if (!Schema::hasColumn('refers', 'approve_status')) {
                $table->string('approve_status')->default('pending')->after('client_id');
            }

            if (!Schema::hasColumn('refers', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('approve_status');
            }

            if (!Schema::hasColumn('refers', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }

            if (!Schema::hasColumn('refers', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('approved_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('refers', function (Blueprint $table) {
            if (Schema::hasColumn('refers', 'created_by')) {
                $table->dropColumn('created_by');
            }

            if (Schema::hasColumn('refers', 'approved_at')) {
                $table->dropColumn('approved_at');
            }

            if (Schema::hasColumn('refers', 'approved_by')) {
                $table->dropColumn('approved_by');
            }

            if (Schema::hasColumn('refers', 'approve_status')) {
                $table->dropColumn('approve_status');
            }
        });
    }
};