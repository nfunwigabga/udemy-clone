<?php

use App\Enums\PaymentStatus;
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
            $table->id();
            $table->string('hashid')->nullable();
            $table->foreignId('payer_id')->constrained('users');
            $table->foreignId('course_id')->constrained();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->foreignId('period_id')->constrained();
            $table->string('gateway_payment_id')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('description');
            $table->decimal('author_earning', 10, 2)->nullable();
            $table->string('status')->default((PaymentStatus::CREATED)->value);
            $table->datetime('refund_deadline');
            $table->datetime('refunded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
