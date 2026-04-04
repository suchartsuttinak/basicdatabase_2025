<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 🔥 ตั้งค่า default role และ status ใหม่
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) NOT NULL DEFAULT 'general_user'");
        DB::statement("ALTER TABLE users MODIFY status VARCHAR(255) NOT NULL DEFAULT '1'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 🔙 ย้อนกลับเป็นค่าเดิม
        DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) NOT NULL DEFAULT 'user'");
        DB::statement("ALTER TABLE users MODIFY status VARCHAR(255) NOT NULL DEFAULT '1'");
    }
};