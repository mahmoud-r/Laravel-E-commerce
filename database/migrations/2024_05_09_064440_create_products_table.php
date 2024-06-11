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
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->double('price',10,2);
            $table->decimal('weight',8,2)->default(0);
            $table->double('compare_price',10,2)->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->enum('is_featured',['Yes','No'])->default('No');
            $table->string('sku');
            $table->integer('max_order');
            $table->integer('qty')->default(1);
            $table->boolean('status')->default(true);
            $table->text('related_product')->nullable();
            $table->text('warranty')->nullable()->default('1 Year Warranty');
            $table->text('return')->nullable()->default('30 Day Return Policy');
            $table->boolean('cachDelivery')->nullable()->default(1);
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
