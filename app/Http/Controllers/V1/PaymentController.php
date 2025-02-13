<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ListDailyOrdersResource;
use App\Http\Resources\V1\ShowPaymentResource;
use App\Models\DailyOrder;
use App\Models\Payment;
use App\Models\Types\DailyOrderStatus;
use App\Models\Types\PaymentType;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function show(string $id)
    {
        $payment = Payment::findOrFail($id);
        
        Log::channel('daily')->info('read payment');

        return [
            'status' => 'OK',
            'message' => 'payment read successfully',
            'data' => new ShowPaymentResource($payment),
        ];
    }

    public function listDailyOrders(string $paymentId)
    {
        Log::channel()->info('list daily orders');

        $payment = Payment::findOrFail($paymentId);
        $dailyOrders = $payment->dailyOrders()->paginate();

        return new ListDailyOrdersResource($dailyOrders);
    }

    public function storePeriodicPayment(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'daily_order_ids' => 'required|array',
        ]);

        /**
         * @var DailyOrder[] $dailyOrders 
         */
        $dailyOrders = DailyOrder::whereIn('id', $request->daily_order_ids)->get();

        $isAllOrdersPending = true;
        foreach ($dailyOrders as $dailyOrder) {    
            if ($dailyOrder['status'] !== 'pending') {
                $isAllOrdersPending = false;
                break;
            }
        }

        if (!$isAllOrdersPending) {
            # throw any exception
        }

        $total = 0;
        foreach ($dailyOrders as $dailyOrder) {    
            $dailyOrder->update([
                'status' => DailyOrderStatus::PAID
            ]);

            $total = $dailyOrder['total'] + $total;
        }

        $paymentData = [
            'total' => $total,
            'paid_at' => (new DateTime())->format('Y-m-d'),
            'type' => PaymentType::IMEDIATE,
            'notes' => $request->notes,
        ];

        $payment = Payment::create($paymentData);

        foreach ($dailyOrders as $dailyOrder) {    
            $dailyOrder->payment()->attach($payment->id);
        }

        return response([
            'status' => 'OK',
            'message' => 'periodic payment created successfully!',
            'data' => new ShowPaymentResource($payment),
        ]);
    }
}
