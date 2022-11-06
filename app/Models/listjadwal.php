<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listjadwal extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_list';
    protected $fillable = [
        'id_peserta',
        'id_jadwal',        
    ];
}
