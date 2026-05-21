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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel categories
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->string('title'); // Judul Dokumen
            $table->year('year')->default(2026); // Tahun Dokumen
            
            // Kolom baru sesuai form yang Anda minta sebelumnya
            $table->string('file_type'); // Menyimpan PDF, DOCX, XLSX, dll
            $table->string('tags')->nullable(); // Menyimpan tag (akreditasi, panduan, dll)
            
            $table->string('file_path'); // Path file yang diunggah secara lokal
            $table->text('description')->nullable();
            
            // Status untuk checkbox Publish/Draft
            $table->string('status')->default('Published'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};