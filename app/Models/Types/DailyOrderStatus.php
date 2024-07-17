<?php

namespace App\Models\Types;

enum DailyOrderStatus: string
{
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
    case PAID = 'paid';
}
