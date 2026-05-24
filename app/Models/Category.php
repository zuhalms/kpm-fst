<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    // Tambahkan kolom-kolom baru agar bisa disimpan ke database
    protected $fillable = [
        'name', 
        'slug', 
        'parent_id', 
        'color', 
        'is_active'
    ];

    /**
     * RELASI: Menghubungkan Kategori ke Dokumen
     * Ini akan memperbaiki error "Call to undefined method App\Models\Category::documents()"
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * RELASI: Menghubungkan ke Induk Kategori (Self-Referencing)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * RELASI: Menghubungkan ke Sub-Kategori
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * METHOD: Hitung Total Dokumen (Langsung + Sub-Kategori)
     */
    public function getTotalDocumentsCount()
    {
        $count = $this->documents()->count();
        
        // Tambah dokumen dari semua sub-kategori
        foreach ($this->children as $child) {
            $count += $child->getTotalDocumentsCount();
        }
        
        return $count;
    }

    // Otomatis membuat slug saat menyimpan nama
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}