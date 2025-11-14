<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Filament Shield resource permissions
        $resources = [
            'user',
            'appointment::type',
            'appointment',
            'eye::examination',
            'category',
            'product',
            'order',
            'blog::post',
            'page',
            'contact::message',
        ];

        $actions = ['view', 'view_any', 'create', 'update', 'delete', 'delete_any'];

        // Create resource permissions
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::create(['name' => $action . '_' . $resource]);
            }
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $staffRole = Role::create(['name' => 'staff', 'guard_name' => 'web']);
        $customerRole = Role::create(['name' => 'customer', 'guard_name' => 'web']);

        // Admin: minden jogosultság
        $adminRole->givePermissionTo(Permission::all());

        // Staff: korlátozott jogosultságok
        $staffPermissions = [];

        // Időpontok kezelése
        foreach ($actions as $action) {
            $staffPermissions[] = $action . '_appointment';
            $staffPermissions[] = $action . '_appointment::type';
            $staffPermissions[] = $action . '_eye::examination';
        }

        // Termékek és kategóriák megtekintése
        $staffPermissions[] = 'view_any_product';
        $staffPermissions[] = 'view_product';
        $staffPermissions[] = 'view_any_category';
        $staffPermissions[] = 'view_category';

        // Rendelések kezelése
        foreach ($actions as $action) {
            $staffPermissions[] = $action . '_order';
        }

        // Kapcsolati üzenetek megtekintése
        $staffPermissions[] = 'view_any_contact::message';
        $staffPermissions[] = 'view_contact::message';

        $staffRole->givePermissionTo($staffPermissions);

        // Customer: nincs Filament panel hozzáférése (csak az alap customer role)

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@optika.hu',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create staff user
        $staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@optika.hu',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $staff->assignRole('staff');

        // Create customer user
        $customer = User::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '+36 30 123 4567',
            'is_active' => true,
        ]);
        $customer->assignRole('customer');
    }
}
