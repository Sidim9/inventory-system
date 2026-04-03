<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'picklist_id',
        'order_number',
        'source',
        'customer_name',
        'customer_email',
        'company_name',
        'phone',
        'street',
        'house_number',
        'house_number_addition',
        'postal_code',
        'city',
        'country',
        'status',
        'notes',
        'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
        'status'     => OrderStatus::class,
    ];

    public static function generateOrderNumber(): string
    {
        $prefix = 'INV-' . now()->format('Ymd') . '-';
        $count = static::where('order_number', 'like', $prefix . '%')->count();
        return $prefix . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }

    public function picklist(): BelongsTo
    {
        return $this->belongsTo(Picklist::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
