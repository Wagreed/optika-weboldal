<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('guest_name')->nullable()->after('customer_id');
            $table->string('guest_email')->nullable()->after('guest_name');
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->unsignedBigInteger('staff_id')->nullable()->change();
            $table->time('start_time')->nullable()->change();
            $table->time('end_time')->nullable()->change();
        });

        // Pending státuszt adunk hozzá – a frontend foglalások először ide kerülnek
        DB::statement(
            "ALTER TABLE appointments MODIFY COLUMN status ENUM('pending','scheduled','confirmed','in_progress','completed','cancelled','no_show') NOT NULL DEFAULT 'pending'"
        );
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_email']);
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
            $table->unsignedBigInteger('staff_id')->nullable(false)->change();
            $table->time('start_time')->nullable(false)->change();
            $table->time('end_time')->nullable(false)->change();
        });

        DB::statement(
            "ALTER TABLE appointments MODIFY COLUMN status ENUM('scheduled','confirmed','in_progress','completed','cancelled','no_show') NOT NULL DEFAULT 'scheduled'"
        );
    }
};
