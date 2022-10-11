<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemDefinition extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'cost',
        'crafting_rotation_id',
        'item_type_id',
    ];

    public function item_type(): BelongsTo
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }
}
