<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->m_update_at = null;
            $model->m_delete_at = null;
        });

        static::updating(function ($model) {
            if (!$model->isDirty('m_delete_at')) {
                $model->m_update_at = now()->setTimezone('Asia/Jakarta');
            }
        });
    }

    public $timestamps = false;
    protected $table = 'modul';
    protected $primaryKey = 'm_id';

    protected $fillable = [
        'm_create_id', 'm_update_id', 'm_delete_id', 'm_guru_id', 'm_nama_modul', 
        'm_modul_kelas', 'm_deskripsi_modul', 'm_foto_atau_pdf', 'm_status', 
        'm_create_at', 'm_update_at', 'm_delete_at'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'm_create_id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'm_update_id');
    }

    public function deleter()
    {
        return $this->belongsTo('App\User', 'm_delete_id');
    }

    public function guru()
    {
        return $this->belongsTo('App\Guru', 'm_guru_id');
    }
}
