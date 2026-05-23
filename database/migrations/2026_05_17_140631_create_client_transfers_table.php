<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_transfers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('from_project_id')->nullable();
            $table->unsignedBigInteger('to_project_id');

            $table->date('transfer_date')->nullable();

            $table->string('status')->default('pending');
            // pending = รออนุมัติ
            // approved = อนุมัติแล้ว
            // rejected = ไม่อนุมัติ
            // cancelled = ยกเลิก

            $table->unsignedBigInteger('requested_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->text('remark')->nullable();

            $table->timestamps();

            $table->index(['client_id', 'status']);
            $table->index(['from_project_id', 'to_project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_transfers');
    }
};