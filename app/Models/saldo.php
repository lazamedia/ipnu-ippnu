<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;

    protected $table = 'saldo';

    protected $fillable = [
        'nama_transaksi',
        'tipe_transaksi',
        'tanggal',
        'pemasukan',
        'pengeluaran',
        'image',
    ];
}
