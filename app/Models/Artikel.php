<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'content', 'author', 'category'
    ];

    // Fungsi untuk mengatur slug otomatis
    public static function boot()
    {
        parent::boot();

        static::creating(function ($artikel) {
            $artikel->slug = \Str::slug($artikel->title);
        });
    }
}
