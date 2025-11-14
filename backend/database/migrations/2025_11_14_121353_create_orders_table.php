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
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->string('order_number', 50)->unique();
            $table->enum('status', ['pending', 'processing', 'ready', 'completed', 'cancelled'])->default('pending');

            // Árak
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // Szállítási adatok
            $table->string('shipping_name');
            $table->string('shipping_email');
            $table->string('shipping_phone', 20)->nullable();
            $table->text('shipping_address');

            // Számlázási adatok
            $table->string('billing_name');
            $table->text('billing_address');
            $table->boolean('billing_same_as_shipping')->default(true);

            // Megjegyzések
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();

            // Időpontok
            $table->timestamp('ordered_at');
            $table->date('estimated_ready_date')->nullable();
            $table->timestamp('completed_at')->nullable();

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
