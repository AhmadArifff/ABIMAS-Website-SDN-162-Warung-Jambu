<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembiasaan extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->p_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('p_delete_at')) {
                $model->p_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    public $timestamps = false;
    protected $table = 'pembiasaan';
    protected $primaryKey = 'p_id';

    protected $fillable = [
        'k_id','p_create_id', 'p_update_id', 'p_delete_id', 'p_nama_kegiatan', 'p_deskripsi', 'p_foto', 'p_status', 'p_create_at', 'p_update_at', 'p_delete_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'p_create_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'p_update_id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'p_delete_id');
    }
    public function create_pembiasaan_by_kesiswaan()
    {
        return $this->belongsTo('App\Kesiswaan', 'k_id');
    }
}
