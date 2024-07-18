<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ListMonthlyOrdersResource;
use App\Http\Resources\V1\MonthlyOrderBaseResource;
use App\Models\MonthlyOrder;

class MonthlyOrderController extends Controller
{
    public function index()
    {
        return new ListMonthlyOrdersResource(MonthlyOrder::paginate());
    }

    public function show(string $id)
    {
        $monthlyOrder = MonthlyOrder::findOrFail($id);

        return [
            'status' => 'OK',
            'message' => 'monthly order read successfully',
            'data' => new MonthlyOrderBaseResource($monthlyOrder),
        ];
    }
}
