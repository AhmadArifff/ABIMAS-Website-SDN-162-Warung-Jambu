<?php
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $table = 'visitor_logs';

    protected $primaryKey = 'v_id';

    public $timestamps = false;

    protected $fillable = [
        'v_ip_address',
        'v_user_agent',
        'v_referer',
        'v_url',
        'v_visited_at'
    ];
}
?>