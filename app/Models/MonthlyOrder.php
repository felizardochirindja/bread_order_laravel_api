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

    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

enum MonthlyOrderStatus: string
{
    case OVERDUE = 'overdue';
    case PENDING = 'pending';
    case INSTALLMENTS = 'installments';
    case PAID = 'paid';
}
