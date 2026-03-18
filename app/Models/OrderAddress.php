<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $fillable = [
        'order_id',
        'type',
        'first_name',
        'last_name',
        'company',
        'street',
        'house_number',
        'house_number_addition',
        'postal_code',
        'city',
        'state',
        'country',
        'phone',
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}
