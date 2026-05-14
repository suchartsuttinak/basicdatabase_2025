<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refers', function (Blueprint $table) {
            $table->id();

            $table->date('refer_date');

            $table->foreignId('translate_id')
                ->constrained('translates')
                ->restrictOnDelete();

            $table->string('destination')->nullable();
            $table->string('address')->nullable();

            $table->enum('guardian', ['มี', 'ไม่มี'])->nullable();

            $table->string('parent_name')->nullable();
            $table->string('parent_tel')->nullable();
            $table->string('member')->nullable();

            $table->string('teacher')->nullable();
            $table->string('committee_result')->nullable();

            $table->text('remark')->nullable();

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            $table->string('meeting_report_file')->nullable();

            $table->enum('approve_status', [
                'pending',
                'approved',
                'rejected',
                'cancelled',
            ])->default('pending');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index('refer_date');
            $table->index('approve_status');
            $table->index(['client_id', 'refer_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refers');
    }
};