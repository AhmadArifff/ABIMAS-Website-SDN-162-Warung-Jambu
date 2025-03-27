<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->so_update_at = null;
            $model->so_delete_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('so_delete_at')) {
                $model->so_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    public $timestamps = false;
    protected $table = 'strukturorganisasi';
    protected $primaryKey = 'so_id';

    protected $fillable = [
        'so_create_id', 'so_update_id', 'so_delete_id', 'so_judul_slide', 'so_deskripsi_slide', 'so_foto_slide', 
        'so_judul_content', 'so_deskripsi', 'so_foto_atau_pdf', 'so_status', 'so_create_at', 'so_update_at', 'so_delete_at'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'so_create_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'so_update_id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'so_delete_id');
    }
}
