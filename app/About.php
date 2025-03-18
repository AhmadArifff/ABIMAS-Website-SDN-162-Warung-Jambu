<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->a_update_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('a_delete_at')) {
                $model->a_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    protected $table = 'about';
    protected $primaryKey = 'a_id';
    public $timestamps = false;

    protected $fillable = [
        'as_id',
        'k_id',
        'a_create_id',
        'a_update_id',
        'a_delete_id',
        'a_visi',
        'a_misi',
        'a_status',
        'a_create_at',
        'a_update_at',
        'a_delete_at'
    ];

    public function kesiswaan()
    {
        return $this->belongsTo('App\Kesiswaan', 'k_id', 'k_id');
    }

    public function sejarah()
    {
        return $this->belongsTo('App\AboutSejarah', 'as_id', 'as_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'a_create_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'a_update_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'a_delete_id', 'id');
    }
}
