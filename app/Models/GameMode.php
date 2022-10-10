<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMode extends Model
{
    use HasFactory;

    public function current_rotation() {
        return $this->belongsTo(MapRotation::class, 'current_rotation_id');
    }

    public function next_rotation() {
        return $this->belongsTo(MapRotation::class, 'next_rotation_id');
    }
}
