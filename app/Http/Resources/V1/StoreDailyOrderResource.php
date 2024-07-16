<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreDailyOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'OK',
            'message' => 'data created successfully',
            'data' => [
                'id' => $this->id,
                'total' => $this->total,
                'quantity' => $this->quantity,
                'productPrice' => $this->product_price,
                'notes' => $this->notes,
                'day' => $this->day,
                'status' => $this->status,
            ],
        ];
    }
}
