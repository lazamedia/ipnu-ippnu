<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'nama_divisi', 'keperluan_divisi'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
