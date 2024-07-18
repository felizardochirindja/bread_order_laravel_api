<?php

namespace App\Models;

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

    use HasFactory;

    public function monthlyOrder(): BelongsToMany
    {
        return $this->belongsToMany(MonthlyOrder::class, 'daily_orders', 'order_id');
    }
}
