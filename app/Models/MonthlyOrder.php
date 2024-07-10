<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyOrder extends Model
{
    public string $id;
    public int $year;
    public Month $month;
    public float $remain;
    public MonthlyOrderStatus $status;
    public Product $product;

    use HasFactory;
}

enum MonthlyOrderStatus: string
{
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
    case INSTALLMENTS = 'installments';
    case PAID = 'paid';
}
