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
            'message' => 'monthly orders read successfully',
            'data' => ShowMonthlyOrderResource::collection($this->collection),
        ];
    }
}
