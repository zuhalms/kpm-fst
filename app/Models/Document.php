<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'year', 'file_type', 
        'tags', 'status', 'file_path', 'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}