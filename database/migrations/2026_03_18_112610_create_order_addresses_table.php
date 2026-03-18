<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->string('type');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company')->nullable();
            $table->string('street');
            $table->string('house_number');
            $table->string('house_number_addition')->nullable();
            $table->string('postal_code');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};