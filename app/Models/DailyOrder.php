<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DailyOrder extends Model
{
    protected $fillable = [
        'day',
        'total',
        'quantity',
        'product_price',
        'notes',
        'status',
        'monthly_order_id',
    ];

    use HasFactory;

    public function monthlyOrder(): BelongsTo
    {
        return $this->belongsTo(MonthlyOrder::class);
    }

    public function payment(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'order_payments');
    }
}
