<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDailyOrderRequest;
use App\Http\Requests\V1\UpdateDailyOrderRequest;
use App\Http\Resources\V1\ListDailyOrdersResource;
use App\Http\Resources\V1\ShowDailyOrderResource;
use App\Http\Resources\V1\StoreDailyOrderResource;
use App\Http\Resources\V1\UpdateDailyOrderResource;
use App\Models\DailyOrder;
use App\Models\MonthlyOrder;
use App\Models\Product;
use App\Models\Types\DailyOrderStatus;
use DateTime;
use Illuminate\Http\Request;

class DailyOrderController extends Controller
{
    public function index()
    {
        return new ListDailyOrdersResource(DailyOrder::paginate());
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
            'status' => DailyOrderStatus::PENDING,
        ];

        $dailyOrder = DailyOrder::create($dailyOrder);
        $dailyOrder->monthlyOrder()->attach($monthlyOrder->id);

        return new StoreDailyOrderResource($dailyOrder);
    }

    public function storeImmediatePaymentOrder(Request $request)
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
            'status' => DailyOrderStatus::PAID,
        ];

        $dailyOrder = DailyOrder::create($dailyOrder);
        $dailyOrder->monthlyOrder()->attach($monthlyOrder->id);

        // find daily orders id where monlty order id = x and order id  = y
        // associate this id with the order payments

        return new StoreDailyOrderResource($dailyOrder);
    }

    public function update(UpdateDailyOrderRequest $request, $id)
    {
        $dailyOrder = DailyOrder::findOrFail($id);
        $dailyOrder->update($request->all());

        return new UpdateDailyOrderResource($dailyOrder);
    }
}
