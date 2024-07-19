<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDailyOrderRequest;
use App\Http\Requests\V1\UpdateDailyOrderRequest;
use App\Http\Resources\V1\ListDailyOrdersResource;
use App\Http\Resources\V1\ShowDailyOrderResource;
use App\Models\DailyOrder;
use App\Models\Month;
use App\Models\MonthlyOrder;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Types\DailyOrderStatus;
use App\Models\Types\MonthlyOrderStatus;
use App\Models\Types\PaymentType;
use DateTime;

class DailyOrderController extends Controller
{
    public function index()
    {
        return new ListDailyOrdersResource(DailyOrder::paginate());
    }

    public function show(DailyOrder $dailyOrder)
    {
        return response([
            'status' => 'OK',
            'message' => 'daily order read successfully',
            'data' => new ShowDailyOrderResource($dailyOrder),
        ]);
    }

    public function store(StoreDailyOrderRequest $request)
    {
        $product = Product::findOrFail($request->productId);

        $monthPosition = (int) (new DateTime())->format('m');

        $month = Month::where('position', $monthPosition)->first();
        $monthlyOrder = MonthlyOrder::where('month_id', $month->id)->first();

        $quantity = (int) $request->quantity;
        $total = $product->price * $quantity;
        $remain = $total;

        if ($monthlyOrder === null) {
            $monthlyOrderData = [
                'year' => (int) (new DateTime())->format('Y'),
                'month_id' => $month->id,
                'total' => $total,
                'remain' => $remain,
                'status' => MonthlyOrderStatus::PENDING,
                'product_id' => $product->id,
            ];

            $monthlyOrder = MonthlyOrder::create($monthlyOrderData);
        } else {
            $monthlyOrderData = [
                'total' => $monthlyOrder->total + $total,
                'remain' => $monthlyOrder->remain + $remain,
            ];

            $monthlyOrder->update($monthlyOrderData);
        }

        $day = (int) (new DateTime())->format('d');

        $dailyOrder = [
            'day' => $day,
            'total' => $total,
            'quantity' => $quantity,
            'product_price' => $product->price,
            'notes' => $request->notes,
            'status' => DailyOrderStatus::PENDING,
            'monthly_order_id' => $monthlyOrder->id
        ];

        $dailyOrder = DailyOrder::create($dailyOrder);

        return response([
            'status' => 'OK',
            'message' => 'daily order created successfully',
            'data' => new ShowDailyOrderResource($dailyOrder),
        ]);
    }

    public function storeImmediatePaymentOrder(StoreDailyOrderRequest $request)
    {
        $product = Product::findOrFail($request->productId);

        $monthPosition = (int) (new DateTime())->format('m');

        $month = Month::where('position', $monthPosition)->first();
        $monthlyOrder = MonthlyOrder::where('month_id', $month->id)->first();

        $quantity = (int) $request->quantity;
        $total = $product->price * $quantity;
        $remain = 0;

        if ($monthlyOrder === null) {
            $monthlyOrderData = [
                'year' => (int) (new DateTime())->format('Y'),
                'month_id' => $month->id,
                'total' => $total,
                'remain' => $remain,
                'status' => MonthlyOrderStatus::PENDING,
                'product_id' => $product->id,
            ];

            $monthlyOrder = MonthlyOrder::create($monthlyOrderData);
        } else {
            $monthlyOrderData = [
                'total' => $monthlyOrder->total + $total,
            ];

            $monthlyOrder->update($monthlyOrderData);
        }

        $day = (int) (new DateTime())->format('d');

        $dailyOrder = [
            'day' => $day,
            'total' => $total,
            'quantity' => $quantity,
            'product_price' => $product->price,
            'notes' => $request->notes,
            'status' => DailyOrderStatus::PAID,
            'monthly_order_id' => $monthlyOrder->id
        ];

        $dailyOrder = DailyOrder::create($dailyOrder);

        $paymentData = [
            'total' => $total,
            'paid_at' => (new DateTime())->format('Y-m-d'),
            'type' => PaymentType::IMEDIATE,
            'notes' => 'felix',
        ];

        $payment = Payment::create($paymentData);
        $dailyOrder->payment()->attach($payment->id);

        return response([
            'status' => 'OK',
            'message' => 'daily order created and paid successfully',
            'data' => new ShowDailyOrderResource($dailyOrder),
        ]);
    }

    public function update(UpdateDailyOrderRequest $request, $id)
    {
        $dailyOrder = DailyOrder::findOrFail($id);
        $dailyOrder->update($request->all());

        return response([
            'status' => 'OK',
            'message' => 'daily order updated successfully',
            'data' => new ShowDailyOrderResource($dailyOrder),
        ]);
    }
}
