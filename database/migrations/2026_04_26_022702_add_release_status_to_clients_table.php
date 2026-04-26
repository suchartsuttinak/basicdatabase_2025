<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('clients', 'release_status')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->enum('release_status', [
                    'show',
                    'refer',
                    'pending_refer'
                ])->default('show')->after('updated_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('clients', 'release_status')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('release_status');
            });
        }
    }
};