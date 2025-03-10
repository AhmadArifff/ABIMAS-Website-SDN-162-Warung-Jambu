<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tatatertib extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->t_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('t_delete_at')) {
                $model->t_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    public $timestamps = false;
    protected $table = 'tatatertib';
    protected $primaryKey = 't_id';

    protected $fillable = [
        'k_id', 't_create_id', 't_update_id', 't_delete_id', 't_nama_peraturan', 't_deskripsi', 't_status', 't_create_at', 't_update_at', 't_delete_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 't_create_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 't_update_id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 't_delete_id');
    }
}
