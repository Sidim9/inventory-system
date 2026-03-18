<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'marketplace_id',
        'external_order_id',
        'order_number',
        'customer_name',
        'customer_email',
        'status',
        'imported_at',
        'sort_order',
        'total_price',
        'currency',
        'notes',
    ];

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class);
    }
    
    public function item()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
