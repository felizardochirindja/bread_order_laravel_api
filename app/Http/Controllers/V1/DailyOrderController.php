<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDailyOrderRequest;
use App\Http\Requests\V1\UpdateDailyOrderRequest;
use App\Http\Resources\V1\ListDailyOrdersResource;
use App\Http\Resources\V1\ShowDailyOrderResource;
use App\Models\DailyOrder;
use App\Models\Payment;
use App\Models\Types\PaymentType;
use App\Services\DailyOrderService;
use DateTime;
use Illuminate\Http\Response as HttpResponse;

class DailyOrderController extends Controller
{
    public function __construct(
        private DailyOrderService $dailyOrderService,
    ) {
    }

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
        $dailyOrder = $this->dailyOrderService->storeDailyOrder(
            $request->quantity,
            $request->productId,
            $request->notes
        );

        return response([
            'status' => 'OK',
            'message' => 'daily order created successfully',
            'data' => new ShowDailyOrderResource($dailyOrder),
        ], HttpResponse::HTTP_CREATED);
    }

    public function storeImmediatePaymentOrder(StoreDailyOrderRequest $request)
    {
        $dailyOrder = $this->dailyOrderService->storeDailyOrder(
            $request->quantity,
            $request->productId,
            $request->notes,
            true
        );

        $paymentData = [
            'total' => $dailyOrder->total,
            'paid_at' => (new DateTime())->format('Y-m-d'),
            'type' => PaymentType::IMEDIATE,
            'notes' => $request->notes,
        ];

        $payment = Payment::create($paymentData);
        $dailyOrder->payment()->attach($payment->id);

        return response([
            'status' => 'OK',
            'message' => 'daily order created and paid successfully',
            'data' => new ShowDailyOrderResource($dailyOrder),
        ], HttpResponse::HTTP_CREATED);
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
