<?php

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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('hashid')->nullable();
            $table->foreignId('cart_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->decimal('price');
            $table->decimal('discount_price')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
