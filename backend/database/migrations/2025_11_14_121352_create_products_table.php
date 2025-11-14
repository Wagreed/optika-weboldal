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
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sku', 100)->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('manage_stock')->default(true);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('frame_material', 100)->nullable();
            $table->string('lens_type', 100)->nullable();
            $table->string('frame_color', 50)->nullable();
            $table->string('frame_size', 20)->nullable();
            $table->enum('gender', ['unisex', 'male', 'female', 'kids'])->default('unisex');
            $table->enum('age_group', ['adult', 'teen', 'child'])->default('adult');
            $table->boolean('is_prescription')->default(false);
            $table->boolean('is_sunglasses')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
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
