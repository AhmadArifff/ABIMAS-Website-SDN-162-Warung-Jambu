<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['nama', 'jabatan', 'gelar', 'masa_kerja', 'foto'];
}
