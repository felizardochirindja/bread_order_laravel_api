<?php

namespace Database\Seeders;

use App\Models\DailyOrder;
use App\Models\MonthlyOrder;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory(1)->create();
        MonthlyOrder::factory(1)->create();
        DailyOrder::factory(5)->create();
    }
}
