<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MonthlyOrder extends Model
{
    use HasFactory;

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function dailyOrders(): BelongsToMany
    {
        return $this->belongsToMany(DailyOrder::class, 'daily_orders', relatedPivotKey: 'order_id');
    }
}
