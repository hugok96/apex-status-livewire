<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_type',
        'server_region',
        'status_code',
        'response_time',
        'status',
        'query_dt',
    ];

    protected $casts = [
        'query_dt' => 'datetime:Y-m-d H:i:s',
    ];
}
