<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyOrder extends Model
{
    private int $day;
    private float $total;
    private int $quantity;
    private float $productPrice;
    private string $notes;
    private OrderStatus $status;

    use HasFactory;
}

enum OrderStatus: string
{
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
    case PAID = 'paid';
}
