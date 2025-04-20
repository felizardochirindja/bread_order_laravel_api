<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonthlyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month_id',
        'total',
        'remain',
        'status',
        'product_id',
    ];

    /**
     * @return BelongsTo<Month, MonthlyOrder>
     */
    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    /**
     * @return BelongsTo<Product, MonthlyOrder>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return HasMany<DailyOrder>
     */
    public function dailyOrders(): HasMany
    {
        return $this->hasMany(DailyOrder::class);
    }
}
