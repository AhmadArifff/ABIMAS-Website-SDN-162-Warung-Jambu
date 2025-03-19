<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    // Nama tabel di database
    protected $table = 'pendaftarans';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'caption',
        'image',
    ];
}