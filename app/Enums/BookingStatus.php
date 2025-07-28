<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending    = 'pending';
    case Confirming = 'confirming';
    case Confirmed  = 'confirmed';
    case Completed  = 'completed';
    case Cancelled  = 'cancelled';

    public function canBeCancelled(): bool
    {
        return in_array($this, [self::Pending, self::Confirming]);
    }

    public function canBeEdited(): bool
    {
        return in_array($this, [self::Pending, self::Confirming]);
    }
}
