<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListMonthlyOrdersResource extends ResourceCollection
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
            'message' => 'data read successfully',
            'data' => $this->collection->transform(function($monthlyOrder) {
                return [
                    'id' => $monthlyOrder->id,
                    'year' => $monthlyOrder->year,
                    'remain' => $monthlyOrder->remain,
                    'status' => $monthlyOrder->status,
                    'month_id' => $monthlyOrder->month_id,
                    'product_id' => $monthlyOrder->product_id,
                ];
            }),
        ];
    }
}
