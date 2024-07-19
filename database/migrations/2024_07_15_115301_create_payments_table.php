<?php

use App\Models\DailyOrder;
use App\Models\Payment;
use App\Models\Types\PaymentType;
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
            $table->enum('type', array_column(PaymentType::cases(), 'value'))->default(PaymentType::PERIOIC)->nullable(false);
            $table->string('notes');
            $table->datetimes();
            $table->charset('utf8mb4');
            $table->collation('utf8mb4_0900_ai_ci');
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->foreignIdFor(DailyOrder::class)->constrained()->cascadeOnDelete();
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
