<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentType;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles, permissions and users
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        // Seed appointment types
        AppointmentType::create([
            'name' => 'Szemvizsgálat',
            'description' => 'Teljes körű szemvizsgálat látásjavítással',
            'duration_minutes' => 45,
            'price' => 8000,
            'color' => '#3498db',
        ]);

        AppointmentType::create([
            'name' => 'Kontroll vizsgálat',
            'description' => 'Kontroll vizsgálat szemüveg/kontaktlencse viselők számára',
            'duration_minutes' => 30,
            'price' => 5000,
            'color' => '#2ecc71',
        ]);

        AppointmentType::create([
            'name' => 'Kontaktlencse illesztés',
            'description' => 'Kontaktlencse illesztés és tanácsadás',
            'duration_minutes' => 60,
            'price' => 10000,
            'color' => '#9b59b6',
        ]);

        // Seed categories
        $eyeglasses = Category::create([
            'name' => 'Szemüvegek',
            'slug' => 'szemuvegek',
            'description' => 'Minden típusú szemüveg',
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Dioptriás szemüvegek',
            'slug' => 'dioptrias-szemuvegek',
            'parent_id' => $eyeglasses->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Napszemüvegek',
            'slug' => 'napszemuvegek',
            'parent_id' => $eyeglasses->id,
            'sort_order' => 2,
        ]);

        $contactLenses = Category::create([
            'name' => 'Kontaktlencsék',
            'slug' => 'kontaktlencsek',
            'description' => 'Minden típusú kontaktlencse',
            'sort_order' => 2,
        ]);

        // Seed products
        Product::create([
            'name' => 'Ray-Ban Aviator Classic',
            'slug' => 'ray-ban-aviator-classic',
            'description' => 'Klasszikus pilóta napszemüveg arany kerettel',
            'short_description' => 'Ikonikus dizájn, UV védelem',
            'sku' => 'RB-AV-001',
            'price' => 45000,
            'stock_quantity' => 15,
            'brand' => 'Ray-Ban',
            'model' => 'Aviator Classic',
            'frame_material' => 'Fém',
            'frame_color' => 'Arany',
            'frame_size' => '58-14-135',
            'gender' => 'unisex',
            'is_sunglasses' => true,
            'featured' => true,
        ]);

        Product::create([
            'name' => 'Modern dioptriás keret - Fekete',
            'slug' => 'modern-dioptrias-keret-fekete',
            'description' => 'Elegáns fekete dioptriás szemüvegkeret könnyű acetat anyagból',
            'short_description' => 'Modern, kényelmes viselés',
            'sku' => 'DK-MOD-BLK-001',
            'price' => 25000,
            'stock_quantity' => 30,
            'brand' => 'OptikaPro',
            'frame_material' => 'Acetat',
            'frame_color' => 'Fekete',
            'frame_size' => '52-17-140',
            'gender' => 'unisex',
            'is_prescription' => true,
        ]);
    }
}
