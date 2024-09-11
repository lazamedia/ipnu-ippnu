<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    use HasFactory;

    // Jika nama tabel di database adalah 'pengurus'
    protected $table = 'pengurus';

    // Jika ada kolom yang tidak ingin diisi secara massal, tambahkan kolom yang dapat diisi
    protected $fillable = ['foto', 'nama_lengkap', 'divisi', 'no_wa', 'email', 'pelajar'];
}
