<?php

namespace App\Services;

use App\Models\DailyOrder;
use App\Models\Month;
use App\Models\MonthlyOrder;
use App\Models\Product;
use App\Models\Types\DailyOrderStatus;
use App\Models\Types\MonthlyOrderStatus;
use DateTime;

class DailyOrderService
{
    public function storeDailyOrder(int $quantity, int $productId, string $notes, bool $isImediatePayment = false): DailyOrder
    {
        $product = Product::findOrFail($productId);
        $monthPosition = (int) (new DateTime())->format('m');
        $month = Month::where('position', $monthPosition)->first();
        $monthlyOrder = MonthlyOrder::where('month_id', $month->id)->first();

        $quantity = $quantity;
        $total = $product->price * $quantity;
        $remain = $isImediatePayment ? 0 : $total;

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
        $dailyOrderData = [
            'day' => $day,
            'total' => $total,
            'quantity' => $quantity,
            'product_price' => $product->price,
            'notes' => $notes,
            'status' => DailyOrderStatus::PENDING,
            'monthly_order_id' => $monthlyOrder->id
        ];

        return DailyOrder::create($dailyOrderData);
    }
}