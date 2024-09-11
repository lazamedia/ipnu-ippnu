<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

     // Tentukan nama tabel yang digunakan
     protected $table = 'events';

     // Tentukan kolom yang bisa diisi secara massal
     protected $fillable = [
        'ketua_pelaksana',
        'wakil',
        'sekretaris',
        'bendahara',
        'tempat',
        'anggaran',
        'tanggal',
        'tamu_undangan',
        'divisi_humas',
        'divisi_acara',
        'divisi_perkap',
        'divisi_dekdok',
        'divisi_konsumsi',
        'keperluan_divisi',
        'foto',
        'file_dokumen',
    ];
 

}
