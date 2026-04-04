<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('operation_date')->comment('วันที่ปฏิบัติงาน');
            $table->unsignedInteger('sequence_no')->comment('ครั้งที่');
            $table->string('subject', 500)->comment('เรื่องที่ดำเนินงาน');
            $table->text('result')->nullable()->comment('ผลการดำเนินงาน');
            $table->text('remark')->nullable()->comment('หมายเหตุ');

            $table->timestamps();

            // 1 user / 1 วัน / 1 ครั้ง -> ห้ามซ้ำ
            $table->unique(
                ['user_id', 'operation_date', 'sequence_no'],
                'operations_user_date_sequence_unique'
            );

            $table->index(['operation_date']);
            $table->index(['user_id', 'operation_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};