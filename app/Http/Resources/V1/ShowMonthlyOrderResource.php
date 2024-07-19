<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowMonthlyOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'total' => (float) $this->total,
            'remain' => (float) $this->remain,
            'status' => $this->status,
            'month' => [
                'id' => $this->month->id,
                'name' => $this->month->name,
            ],
            'product' => [
                "id" => $this->product->id,
                "name" => $this->product->name,
                "price" => (float) $this->product->price,
                "description" => $this->product->description,
            ],
        ];
    }
}
