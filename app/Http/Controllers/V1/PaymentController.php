<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ListDailyOrdersResource;
use App\Http\Resources\V1\ShowPaymentResource;
use App\Models\MonthlyOrder;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function show(string $id)
    {
        $payment = Payment::findOrFail($id);
        
        return [
            'status' => 'OK',
            'message' => 'payment read successfully',
            'data' => new ShowPaymentResource($payment),
        ];
    }

    public function listByMonthlyOrderId(string $monthlyOrderId)
    {
        $monthlyOrder = MonthlyOrder::findOrFail($monthlyOrderId);
    }

    public function listDailyOrders(string $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $dailyOrders = $payment->dailyOrders()->paginate();

        return new ListDailyOrdersResource($dailyOrders);
    }

    public function makePeriodicPayment()
    {
        
    }
}
