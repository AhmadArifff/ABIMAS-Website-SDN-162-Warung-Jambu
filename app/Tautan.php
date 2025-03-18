<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tautan extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tt_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('tt_delete_at')) {
                $model->tt_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    protected $table = 'tautan';
    protected $primaryKey = 'tt_id';
    public $timestamps = false;

    protected $fillable = [
        'tt_create_id',
        'tt_update_id',
        'tt_delete_id',
        'tt_nama_tautan',
        'tt_url',
        'tt_create_at',
        'tt_update_at',
        'tt_delete_at'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'tt_create_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'tt_update_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'tt_delete_id', 'id');
    }
}
