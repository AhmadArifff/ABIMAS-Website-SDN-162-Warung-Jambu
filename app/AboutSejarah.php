<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutSejarah extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->as_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('as_delete_at')) {
                $model->as_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    protected $table = 'about_sejarah';
    protected $primaryKey = 'as_id';
    public $timestamps = false;

    protected $fillable = [
        'k_id',
        'as_create_id',
        'as_update_id',
        'as_delete_id',
        'as_sejarah',
        'as_create_at',
        'as_update_at',
        'as_delete_at'
    ];

    public function kesiswaan()
    {
        return $this->belongsTo('App\Kesiswaan', 'k_id', 'k_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'as_create_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'as_update_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'as_delete_id', 'id');
    }
}
