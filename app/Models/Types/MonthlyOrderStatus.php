<?php

namespace App\Models\Types;

enum MonthlyOrderStatus: string
{
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
    case INSTALLMENTS = 'installments';
    case PAID = 'paid';
}
