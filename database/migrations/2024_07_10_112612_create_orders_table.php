<?php

use App\Models\DailyOrder;
use App\Models\MonthlyOrder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->decimal('total', 10, 2)->unsigned();
            $table->unsignedTinyInteger('quantity');
            $table->decimal('product_price', 10, 2)->unsigned();
            $table->string('notes');
            $table->unsignedTinyInteger('day');
            $table->enum('status', ['overdue', 'pending', 'paid']);
            $table->datetimes();
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_0900_ai_ci');
        });

        Schema::create('daily_orders', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->foreignIdFor(MonthlyOrder::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(DailyOrder::class, 'order_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('daily_orders');
    }
};
