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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street');
            $table->string('building');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('district')->nullable();
            $table->foreignId('governorate_id')->constrained()->onDelete('cascade');
            $table->string('nearest_landmark')->nullable();
            $table->string('phone',11);
            $table->string('second_phone',11)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
