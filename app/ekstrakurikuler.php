<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->e_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('e_delete_at')) {
                $model->e_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    public $timestamps = false;
    protected $table = 'ekstrakurikuler';
    protected $primaryKey = 'e_id';

    protected $fillable = [
        'e_create_id', 'e_update_id', 'e_delete_id', 'e_judul_slide', 'e_deskripsi_slide', 'e_foto_slide1', 'e_foto_slide2', 'e_foto_slide3', 'e_nama_ekstrakurikuler', 'e_deskripsi', 'e_foto', 'e_status', 'e_create_at', 'e_update_at', 'e_delete_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'e_create_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'e_update_id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'e_delete_id');
    }
}
