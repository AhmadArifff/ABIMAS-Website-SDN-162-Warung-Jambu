<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaSosial extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ms_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('ms_delete_at')) {
                $model->ms_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    protected $table = 'media_sosial';
    protected $primaryKey = 'ms_id';
    public $timestamps = false;

    protected $fillable = [
        'ms_create_id',
        'ms_update_id',
        'ms_delete_id',
        'ms_nama_media',
        'ms_url',
        'ms_create_at',
        'ms_update_at',
        'ms_delete_at'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'ms_create_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'ms_update_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'ms_delete_id', 'id');
    }
}
