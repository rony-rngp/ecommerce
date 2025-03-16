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
            $table->integer('user_id');
            $table->enum('shipping_type', ['In Dhaka', 'Outside Dhaka']);
            $table->text('shipping_info');
            $table->enum('payment_type', ['online', 'offline'])->nullable();
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->text('offline_payment_info')->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('subtotal');
            $table->float('coupon_discount')->default(0);
            $table->float('shipping_charge');
            $table->float('grand_total');
            $table->tinyInteger('payment_status')->default(0);
            $table->string('status');
            $table->tinyInteger('is_seen')->default(0);
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
