<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CraftingRotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle',
        'bundleType',
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
    ];

    public function items() {
        return $this->hasMany(ItemDefinition::class, 'crafting_rotation_id');
    }
}
