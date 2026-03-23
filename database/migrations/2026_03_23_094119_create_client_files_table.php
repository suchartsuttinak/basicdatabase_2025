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
        Schema::create('client_files', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('client_id');
        $table->string('file_type');   // เช่น id_card, house_registration
        $table->string('file_name');   // ชื่อไฟล์จริง เช่น id_card_123.pdf
        $table->string('file_path');   // path ของไฟล์ pdf ใน storage
        $table->timestamp('uploaded_at')->nullable();
        $table->timestamps();

        // Cascade delete เมื่อ client ถูกลบ
        $table->foreign('client_id')
              ->references('id')
              ->on('clients')
              ->onDelete('cascade');
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_files');
    }
};
