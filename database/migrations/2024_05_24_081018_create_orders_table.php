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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->double('subtotal',10,2);
            $table->double('shipping',10,2);
            $table->string('coupon_code')->nullable();
            $table->string('payment_method');
            $table->integer('coupon_code_id')->nullable();
            $table->double('discount',10,2)->nullable();
            $table->double('grand_total',10,2);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
