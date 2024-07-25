<?php

namespace Database\Seeders;

use App\Models\DailyOrder;
use App\Models\Month;
use App\Models\MonthlyOrder;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();
        Product::factory(1)->create();
        Month::factory(11)->create();
        MonthlyOrder::factory(1)->create();
        DailyOrder::factory(5)->create();
        Payment::factory(2)->create();

        DB::table('order_payments')->insert([
            [
                'daily_order_id' => 1,
                'payment_id' => 1,
            ],
            [
                'daily_order_id' => 2,
                'payment_id' => 1,
            ],
            [
                'daily_order_id' => 3,
                'payment_id' => 1,
            ],
            [
                'daily_order_id' => 4,
                'payment_id' => 2,
            ],
            [
                'daily_order_id' => 5,
                'payment_id' => 2,
            ],
        ]);
    }
}
