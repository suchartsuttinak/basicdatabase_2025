<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // ปิดไว้ เพราะมี migration ใหม่สร้างตาราง psychiatrics แล้ว
    }

    public function down(): void
    {
        // ปิดไว้ เพื่อป้องกัน rollback แล้วลบตาราง psychiatrics โดยไม่ตั้งใจ
    }
};