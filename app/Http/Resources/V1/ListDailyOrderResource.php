<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListDailyOrderResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'OK',
            'message' => 'data read successfully',
            'data' => $this->collection->transform(function($dailyOrder) {
                return [
                    'id' => $dailyOrder->id,
                    'total' => $dailyOrder->total,
                    'quantity' => $dailyOrder->quantity,
                    'productPrice' => $dailyOrder->product_price,
                    'notes' => $dailyOrder->notes,
                    'day' => $dailyOrder->day,
                    'status' => $dailyOrder->status,
                ];
            }),
        ];
    }
}
