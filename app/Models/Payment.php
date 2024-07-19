<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends Model
{
    use HasFactory;

    public function dailyOrders(): BelongsToMany
    {
        return $this->belongsToMany(DailyOrder::class, 'order_payments');
    }
}
