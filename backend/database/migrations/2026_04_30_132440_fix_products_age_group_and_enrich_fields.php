<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// SQLite esetén az ENUM csak string — nincs séma-szintű kényszer.
// Ez a migráció a meglévő 'teen' értékeket frissíti 'adult'-ra,
// hogy szinkronban legyen a frontend ageLabel() és recommendedFor() logikával.
return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')
            ->where('age_group', 'teen')
            ->update(['age_group' => 'adult']);
    }

    public function down(): void
    {
        // 'teen' → 'adult' konverzió visszafordíthatatlan adatvesztés nélkül
    }
};
