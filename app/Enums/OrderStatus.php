<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending  = 'pending';
    case Shipped  = 'shipped';
    case Received = 'received';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Wachtend',
            self::Shipped  => 'Verzonden',
            self::Received => 'Ontvangen',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending  => 'warning',
            self::Shipped  => 'primary',
            self::Received => 'success',
        };
    }
}
