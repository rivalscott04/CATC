<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_jadwal';
    protected $fillable = [
        'tanggal',
        'waktu',
        'jenis',
        'kuota'
        
    ];
}
