<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->b_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('b_delete_at')) {
                $model->b_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    protected $table = 'berita';
    protected $primaryKey = 'b_id';
    public $timestamps = false;

    protected $fillable = [
        'k_id',
        'b_create_id',
        'b_update_id',
        'b_delete_id',
        'b_nama_berita',
        'b_deskripsi_berita',
        'b_foto_berita',
        'b_create_at',
        'b_update_at',
        'b_delete_at'
    ];

    public function kesiswaan()
    {
        return $this->belongsTo('App\Kesiswaan', 'k_id', 'k_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'b_create_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'b_update_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'b_delete_id', 'id');
    }
}
