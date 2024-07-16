<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDailyOrderRequest;
use App\Http\Requests\V1\UpdateDailyOrderRequest;
use App\Http\Resources\V1\DailyOrderCollection;
use App\Http\Resources\V1\DailyOrderResource;
use App\Http\Resources\V1\StoreDailyOrderResource;
use App\Http\Resources\V1\UpdateDailyOrderResource;
use App\Models\DailyOrder;

class DailyOrderController extends Controller
{
    public function index()
    {
        return new DailyOrderCollection(DailyOrder::all());
    }

    public function show(DailyOrder $dailyOrder)
    {
        return new DailyOrderResource($dailyOrder);
    }

    public function store(StoreDailyOrderRequest $request)
    {
        $dailyOrder = DailyOrder::create($request->all());
        return new StoreDailyOrderResource($dailyOrder);
    }

    public function update(UpdateDailyOrderRequest $request, $id)
    {
        $dailyOrder = DailyOrder::findOrFail($id);
        $dailyOrder->update($request->all());

        return new UpdateDailyOrderResource($dailyOrder);
    }
}
