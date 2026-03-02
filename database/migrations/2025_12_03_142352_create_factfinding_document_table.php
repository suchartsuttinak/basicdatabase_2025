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
        Schema::create('factfinding_documents', function (Blueprint $table) {
            $table->id();

        // FK ไปที่ factfindings
        $table->foreignId('factfinding_id')
              ->constrained('factfindings')
              ->onDelete('cascade');

        // FK ไปที่ documents
        $table->foreignId('document_id')
              ->constrained('documents')
              ->onDelete('cascade');

        // ป้องกันการซ้ำ factfinding_id + document_id
        $table->unique(['factfinding_id', 'document_id']);

        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factfinding_document');
    }
};
