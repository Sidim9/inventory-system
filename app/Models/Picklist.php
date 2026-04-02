<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Picklist extends Model
{
    protected $fillable = [
        'name',
        'total_items',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'total_items' => 'integer',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
