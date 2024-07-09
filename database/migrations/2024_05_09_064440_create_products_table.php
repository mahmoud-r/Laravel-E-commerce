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
            $table->foreignId('sub_category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('sku');
            $table->integer('max_order');
            $table->integer('qty')->default(1);
            $table->boolean('status')->default(true);
            $table->text('related_product')->nullable();
            $table->text('warranty')->nullable()->default(null);
            $table->text('return')->nullable()->default(null);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->enum('seo_index',['index','noindex'])->default('index');
            $table->double('flash_sale_price', 10, 2)->nullable();
            $table->dateTime('flash_sale_expiry_date')->nullable();
            $table->integer('flash_sale_qty')->nullable();
            $table->integer('flash_sale_qty_solid')->nullable()->default(0);
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
