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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('address_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street');
            $table->string('building');
            $table->foreignId('city_id')->constrained();
            $table->string('district')->nullable();
            $table->foreignId('governorate_id')->constrained();
            $table->string('nearest_landmark')->nullable();
            $table->string('phone',11);
            $table->string('second_phone',11)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
