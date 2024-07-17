<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDailyOrderRequest;
use App\Http\Requests\V1\UpdateDailyOrderRequest;
use App\Http\Resources\V1\ListDailyOrderResource;
use App\Http\Resources\V1\ShowDailyOrderResource;
use App\Http\Resources\V1\StoreDailyOrderResource;
use App\Http\Resources\V1\UpdateDailyOrderResource;
use App\Models\DailyOrder;
use App\Models\MonthlyOrder;
use App\Models\Product;
use DateTime;

class DailyOrderController extends Controller
{
    public function index()
    {
        return new ListDailyOrderResource(DailyOrder::paginate());
    }

    public function show(DailyOrder $dailyOrder)
    {
        return new ShowDailyOrderResource($dailyOrder);
    }

    public function store(StoreDailyOrderRequest $request)
    {
        $product = Product::findOrFail($request->productId);
        $monthlyOrder = MonthlyOrder::findOrFail($request->monthlyOrderId);

        $quantity = (int) $request->quantity;
        $total = $product->price * $quantity;
        $day = (new DateTime())->format('d');

        $dailyOrder = [
            'day' => $day,
            'total' => $total,
            'quantity' => $quantity,
            'product_price' => $product->price,
            'notes' => $request->notes,
            'status' => 'pending',
        ];

        $dailyOrder = DailyOrder::create($dailyOrder);
        $dailyOrder->monthlyOrder()->attach($monthlyOrder->id);

        return new StoreDailyOrderResource($dailyOrder);
    }

    public function placeImmediatePaymentOrder()
    {
        
    }

    public function update(UpdateDailyOrderRequest $request, $id)
    {
        $dailyOrder = DailyOrder::findOrFail($id);
        $dailyOrder->update($request->all());

        return new UpdateDailyOrderResource($dailyOrder);
    }
}
