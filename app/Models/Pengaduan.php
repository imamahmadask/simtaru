<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduans';
    
    protected $fillable = [
        'jenis',
        'nama',
        'alamat',
        'no_hp',
        'pengaduan',
    ];
}
