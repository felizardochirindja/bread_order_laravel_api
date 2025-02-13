<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ListDailyOrdersResource;
use App\Http\Resources\V1\ListMonthlyOrdersResource;
use App\Http\Resources\V1\ListPaymentsResource;
use App\Http\Resources\V1\ShowMonthlyOrderResource;
use App\Models\MonthlyOrder;
use Illuminate\Support\Facades\Log;

class MonthlyOrderController extends Controller
{
    public function index()
    {
        return new ListMonthlyOrdersResource(MonthlyOrder::paginate());
    }

    public function show(string $id)
    {
        $monthlyOrder = MonthlyOrder::findOrFail($id);

        Log::channel('daily')->info('read monthly order');

        return [
            'status' => 'OK',
            'message' => 'monthly order read successfully',
            'data' => new ShowMonthlyOrderResource($monthlyOrder),
        ];
    }

    public function listDailyOrders(string $monthlyOrderId)
    {
        $monthlyOrder = MonthlyOrder::findOrFail($monthlyOrderId);
        $dailyOrders = $monthlyOrder->dailyOrders()->paginate();

        Log::channel('daily')->info('list daily orders by monthly order id');

        return new ListDailyOrdersResource($dailyOrders);
    }

    public function listPayments(string $monthlyOrderId)
    {
        $monthlyOrder = MonthlyOrder::findOrFail($monthlyOrderId);

        $payments = $monthlyOrder->dailyOrders()
            ->with('payment')
            ->get()
            ->pluck('payment')
            ->flatten()
            ->unique('id');

        return new ListPaymentsResource($payments);
    }
}
