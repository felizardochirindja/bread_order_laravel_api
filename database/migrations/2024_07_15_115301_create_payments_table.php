<?php

use App\Models\Payment;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->decimal('total', 10, 2)->nullable(false);
            $table->dateTime('paid_at')->nullable(false);
            $table->enum('type', ['periodic', 'daily'])->nullable(false);
            $table->string('notes');
            $table->datetimes();
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_0900_ai_ci');
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->unsignedBigInteger('daily_order_id');
            $table->foreign('daily_order_id')->references('id')->on('daily_orders')->cascadeOnDelete();
            $table->foreignIdFor(Payment::class)->constrained()->cascadeOnDelete();
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_0900_ai_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_payments');
    }
};
