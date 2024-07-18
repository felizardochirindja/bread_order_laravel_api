<?php

namespace App\Http\Resources\V1;

use App\Models\DailyOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListDailyOrdersResource extends ResourceCollection
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
            'message' => 'daily orders read successfully',
            'data' => $this->collection->transform(function (DailyOrder $dailyOrder) {
                return new ShowDailyOrderResource($dailyOrder);
            }),
        ];
    }
}
