<?php

use App\Models\Product;
use App\Models\Types\MonthlyOrderStatus;
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
        Schema::create('monthly_orders', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->unsignedSmallInteger('year');
            $table->decimal('remain', 10, 2)->unsigned();
            $table->enum('status', array_column(MonthlyOrderStatus::cases(), 'value'))->default(MonthlyOrderStatus::PENDING);
            $table->decimal('total', 10, 2)->unsigned();
            $table->unsignedTinyInteger('month_id');
            $table->foreign('month_id')->references('id')->on('months')->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->datetimes();
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_0900_ai_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_orders');
    }
};
