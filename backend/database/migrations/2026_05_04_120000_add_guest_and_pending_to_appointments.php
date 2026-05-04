<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Az első futás részben sikeres volt: guest_name/email + nullable oszlopok már léteznek
        if (! Schema::hasColumn('appointments', 'guest_name')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->string('guest_name')->nullable()->after('customer_id');
                $table->string('guest_email')->nullable()->after('guest_name');
                $table->unsignedBigInteger('customer_id')->nullable()->change();
                $table->unsignedBigInteger('staff_id')->nullable()->change();
                $table->time('start_time')->nullable()->change();
                $table->time('end_time')->nullable()->change();
            });
        }

        // Status oszlop drop + recreate: 'pending' értékkel bővítjük az enum-ot
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'])
                ->default('pending')
                ->after('end_time');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'])
                ->default('scheduled')
                ->after('end_time');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_email']);
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
            $table->unsignedBigInteger('staff_id')->nullable(false)->change();
            $table->time('start_time')->nullable(false)->change();
            $table->time('end_time')->nullable(false)->change();
        });
    }
};
