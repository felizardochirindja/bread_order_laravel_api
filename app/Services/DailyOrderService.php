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
    public function storeDailyOrder(
        int $quantity,
        int $productId,
        string $notes,
        bool $isImediatePayment = false
    ): DailyOrder {
        $product = Product::findOrFail($productId);
        $monthPosition = (int) (new DateTime())->format('m');
        $month = Month::where('position', $monthPosition)->first();
        $monthlyOrder = MonthlyOrder::where('month_id', $month->id)->first();

        $quantity = $quantity;
        $total = $product->price * $quantity;
        $remain = $isImediatePayment ? 0 : $total;

        // caso nesse mes ainda nao tenha sido criado um pedo mensal
        // o sistema cria automaticamente
        if ($monthlyOrder === null) {
            $monthlyOrderData = [
                'year' => (int) (new DateTime())->format('Y'),
                'month_id' => $month->id,
                'total' => $total,
                'remain' => $remain,
                'status' => MonthlyOrderStatus::PAID,
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
        $status = $isImediatePayment ? DailyOrderStatus::PAID : DailyOrderStatus::PENDING;

        $dailyOrderData = [
            'day' => $day,
            'total' => $total,
            'quantity' => $quantity,
            'product_price' => $product->price,
            'notes' => $notes,
            'status' => $status,
            'monthly_order_id' => $monthlyOrder->id
        ];

        return DailyOrder::create($dailyOrderData);
    }
}
