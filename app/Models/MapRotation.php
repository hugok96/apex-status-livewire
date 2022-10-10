<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapRotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'name',
        'asset',
        'duration',
        'code'
    ];

    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
    ];
}
