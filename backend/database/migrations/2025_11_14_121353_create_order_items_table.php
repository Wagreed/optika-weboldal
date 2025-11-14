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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('examination_id')->nullable()->constrained('eye_examinations')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);

            // Dioptriás adatok
            $table->decimal('prescription_right_sphere', 4, 2)->nullable();
            $table->decimal('prescription_right_cylinder', 4, 2)->nullable();
            $table->integer('prescription_right_axis')->nullable();
            $table->decimal('prescription_left_sphere', 4, 2)->nullable();
            $table->decimal('prescription_left_cylinder', 4, 2)->nullable();
            $table->integer('prescription_left_axis')->nullable();
            $table->decimal('pupillary_distance', 4, 1)->nullable();

            // Egyéb specifikációk
            $table->string('lens_type', 100)->nullable();
            $table->string('lens_coating', 100)->nullable();
            $table->text('special_instructions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
