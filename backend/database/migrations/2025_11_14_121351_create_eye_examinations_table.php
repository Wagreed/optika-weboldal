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
        Schema::create('eye_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('examiner_id')->constrained('users')->onDelete('cascade');
            $table->date('examination_date');

            // Látásélesség
            $table->string('visual_acuity_right_eye', 10)->nullable();
            $table->string('visual_acuity_left_eye', 10)->nullable();

            // Dioptria értékek
            $table->decimal('sphere_right', 4, 2)->nullable();
            $table->decimal('cylinder_right', 4, 2)->nullable();
            $table->integer('axis_right')->nullable();
            $table->decimal('sphere_left', 4, 2)->nullable();
            $table->decimal('cylinder_left', 4, 2)->nullable();
            $table->integer('axis_left')->nullable();

            // Pupillatávolság
            $table->decimal('pupillary_distance', 4, 1)->nullable();

            // Szemnyomás
            $table->integer('intraocular_pressure_right')->nullable();
            $table->integer('intraocular_pressure_left')->nullable();

            // Színlátás
            $table->string('color_vision_test_result', 50)->nullable();

            // Megjegyzések
            $table->text('examination_notes')->nullable();
            $table->text('recommendations')->nullable();
            $table->date('next_examination_recommended')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eye_examinations');
    }
};
