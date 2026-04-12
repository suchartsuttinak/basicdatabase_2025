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
        Schema::create('followups', function (Blueprint $table) {
              $table->id();

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete(); // ถ้า client ถูกลบ followup ถูกลบตาม

            $table->date('followup_date')->comment('วันเดือนปี');
            $table->text('assistance_detail')->comment('การช่วยเหลือและติดตามผล');
            $table->text('note')->nullable()->comment('หมายเหตุ');

            $table->timestamps();

            $table->index('client_id');
            $table->index('followup_date');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followups');
    }
};
