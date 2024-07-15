<?php

use App\Models\Month;
use App\Models\Product;
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
            $table->enum('status', ['overdue', 'pending', 'installments', 'paid']);
            $table->foreignIdFor(Month::class);
            $table->foreignIdFor(Product::class);
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
