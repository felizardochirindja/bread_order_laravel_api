<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ListMonthlyOrdersResource;
use App\Models\MonthlyOrder;

class MonthlyOrderController extends Controller
{
    public function index()
    {
        return new ListMonthlyOrdersResource(MonthlyOrder::paginate());
    }
}
