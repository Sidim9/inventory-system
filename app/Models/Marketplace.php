<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    protected $fillable = [
        'name',
        'code',
        'api_base_url',
        'is_active',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
