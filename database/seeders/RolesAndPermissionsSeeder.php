<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $calendarPermissions = [
            'view-calendar',
            'create-calendar',
            'edit-calendar',
            'delete-calendar',
        ];

        $legendPermissions = [
            'view-legend',
            'create-legend',
            'update-legend',
            'delete-legend',
        ];

        $userPermissions = [
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
        ];

        $profilePermissions = [
            'view-profile',
            'update-profile',
        ];

        $settingsPermissions = [
            'view-settings',
            'edit-settings',
        ];

        $rolePermissions = [
            'view-role',
            'create-role',
            'edit-role',
            'delete-role',
            'change-role',
        ];

        $permissionPermissions = [
            'view-permission',
            'create-permission',
            'edit-permission',
            'delete-permission',
        ];

        $permissions = [
            ...$calendarPermissions,
            ...$legendPermissions,
            ...$userPermissions,
            ...$profilePermissions,
            ...$settingsPermissions,
            ...$rolePermissions,
            ...$permissionPermissions,
        ];

        Permission::query()->delete();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'super-admin'])->givePermissionTo([
            ...$calendarPermissions,
            ...$profilePermissions,
            ...$legendPermissions,
            ...$userPermissions,
            ...$rolePermissions,
            ...$permissionPermissions,
        ]);

        Role::create(['name' => 'super-user'])->givePermissionTo([
            ...$calendarPermissions,
            ...$legendPermissions,
            ...$userPermissions,
            ...$profilePermissions,
            ...$settingsPermissions,
        ]);

        Role::create(['name' => 'admin'])->givePermissionTo([
            ...$calendarPermissions,
            ...$legendPermissions,
            ...$userPermissions,
            ...$profilePermissions,
        ]);

        Role::create(['name' => 'editor'])->givePermissionTo([
            ...$calendarPermissions,
            ...$legendPermissions,
            ...$profilePermissions,
        ]);

    }
}
