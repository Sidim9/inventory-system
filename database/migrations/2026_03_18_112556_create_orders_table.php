<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marketplace_id')
                ->nullable()
                ->constrained('marketplaces')
                ->nullOnDelete();

            $table->string('external_order_id');
            $table->string('order_number');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('imported_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamp('stock_processed_at')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};