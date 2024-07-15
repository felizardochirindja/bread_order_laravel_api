<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyOrder extends Model
{
    protected $table = 'orders';

    private int $day;
    private float $total;
    private int $quantity;
    private float $productPrice;
    private string $notes;
    private OrderStatus $status;

    use HasFactory;

    public function monthlyOrder()
    {
        return $this->belongsToMany(MonthlyOrder::class, 'daily_orders', 'order_id')->first();
    }
}

enum OrderStatus: string
{
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
    case PAID = 'paid';
}
