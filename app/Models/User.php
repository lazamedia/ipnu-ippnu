<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk menggunakan Storage

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'foto', // gambar profil pengguna
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 9 hashing password otomatis
    ];

    /**
     * Relasi: User memiliki banyak Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Menghapus gambar profil saat user dihapus
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Hapus gambar profil dari storage jika ada
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }
        });
    }
}
