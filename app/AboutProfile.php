<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutProfile extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->updated_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('deleted_at')) {
                $model->updated_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    protected $table = 'abouts';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'caption',
        'image'
    ];
}
