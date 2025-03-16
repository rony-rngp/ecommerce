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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('subcategory_id')->nullable();
            $table->integer('brand_id');
            $table->string('sku');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->float('price');
            $table->float('discount')->default(0);
            $table->text('short_description');
            $table->text('description');
            $table->string('image');
            $table->tinyInteger('has_attribute')->default(1);
            $table->string('attribute_title')->nullable();
            $table->integer('stock')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('hot_deals')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
