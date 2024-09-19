<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;
    use HasFactory;

    // Melindungi kolom id dari mass assignment
    protected $guarded = ['id'];
    
    // Eager load kategori dan author untuk setiap query
    protected $with = ['category', 'author'];

    /**
     * Scope untuk filtering query berdasarkan search, category, dan author
     */
    public function scopeFilter($query, array $filters)
    {     
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where('title', 'like','%' . $search. '%' )
                       ->orWhere('body', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function($query, $category) {
            return $query->whereHas('category', function($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when($filters['author'] ?? false, function($query, $author) {
            return $query->whereHas('author', function($query) use ($author) {
                $query->where('username', $author);
            });
        });
    }

    /**
     * Relasi ke model Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke model User (author)
     * Menggunakan kolom user_id sebagai foreign key
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Gunakan slug sebagai key untuk route
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Mengatur sluggable untuk membuat slug otomatis dari title
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
