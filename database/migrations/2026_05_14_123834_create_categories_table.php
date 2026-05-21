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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // 1. Relasi ke diri sendiri (Self-Referencing) untuk "Induk Kategori"
            $table->foreignId('parent_id')
                  ->nullable() 
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique();
            
            // 2. Kolom untuk "Warna Label" (Menyimpan kode hex seperti #3B82F6)
            $table->string('color')->default('#3B82F6');
            
            // 3. Kolom untuk status "Kategori Aktif"
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nonaktifkan foreign key check sementara agar drop table lancar pada self-relation
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('categories');
        Schema::enableForeignKeyConstraints();
    }
};