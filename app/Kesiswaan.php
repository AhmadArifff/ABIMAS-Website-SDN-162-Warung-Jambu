<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kesiswaan extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->k_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('k_delete_at')) {
                $model->k_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    public $timestamps = false;
    protected $table = 'kesiswaan';
    protected $primaryKey = 'k_id';

    protected $fillable = [
        'k_create_id',
        'k_update_id',
        'k_delete_id',
        'k_nama_menu',
        'k_judul_slide',
        'k_deskripsi_slide',
        'k_judul_isi_content',
        'k_foto_slide1',
        'k_foto_slide2',
        'k_foto_slide3',
        'k_status',
        'k_create_at',
        'k_update_at',
        'k_delete_at',
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'k_create_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'k_update_id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'k_delete_id');
    }
    public function penghargaan()
    {
        return $this->hasMany(Penghargaan::class, 'k_id');
    }

    public function pembiasaan()
    {
        return $this->hasMany(Pembiasaan::class, 'k_id');
    }
}