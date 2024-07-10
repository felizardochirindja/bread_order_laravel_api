<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyOrder extends Model
{
    private string $id;
    private int $year;
    private Month $month;
    private float $remain;
    private MonthlyOrderStatus $status;
    private Product $product;

    use HasFactory;
}

enum MonthlyOrderStatus: string
{
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
    case INSTALLMENTS = 'installments';
    case PAID = 'paid';
}
