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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->tinyInteger('has_attribute')->default(1);
            $table->string('attribute_title')->nullable();
            $table->string('product_attribute')->nullable();
            $table->string('product_color')->nullable();
            $table->float('product_price');
            $table->integer('product_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
