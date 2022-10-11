<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameMode extends Model
{
    use HasFactory;

    public function current_rotation(): BelongsTo
    {
        return $this->belongsTo(MapRotation::class, 'current_rotation_id');
    }

    public function next_rotation(): BelongsTo
    {
        return $this->belongsTo(MapRotation::class, 'next_rotation_id');
    }
}
