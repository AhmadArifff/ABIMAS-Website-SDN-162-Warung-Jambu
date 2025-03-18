<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ph_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('ph_delete_at')) {
                $model->ph_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    public $timestamps = false;
    protected $table = 'penghargaan';
    protected $primaryKey = 'ph_id';

    protected $fillable = [
        'k_id', 'e_id', 'ph_create_id', 'ph_update_id', 'ph_delete_id', 'ph_nama_kegiatan', 'ph_deskripsi', 'ph_foto', 'ph_status', 'ph_create_at', 'ph_update_at', 'ph_delete_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'ph_create_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'ph_update_id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'ph_delete_id');
    }
}
