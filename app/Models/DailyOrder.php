<?php

namespace App\Models;

use App\Models\Types\DailyOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DailyOrder extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'day',
        'total',
        'quantity',
        'product_price',
        'notes',
        'status',
    ];

    private int $day;
    private float $total;
    private int $quantity;
    private float $productPrice;
    private string $notes;
    private DailyOrderStatus $status;

    use HasFactory;

    public function monthlyOrder(): BelongsToMany
    {
        return $this->belongsToMany(MonthlyOrder::class, 'daily_orders', 'order_id');
    }
}
