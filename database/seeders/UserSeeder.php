<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $englishLanguage = Language::where('code', 'en')->first()->id;

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'organization_id' => 1,
        ])->assignRole('super-admin')
            ->languages()
            ->attach($englishLanguage);

        User::create([
            'name' => 'Super User',
            'email' => 'superuser@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'organization_id' => 2,
        ])->assignRole('super-user')
            ->languages()
            ->attach($englishLanguage);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'organization_id' => 3,
        ])->assignRole('admin')
            ->languages()
            ->attach($englishLanguage);

        User::create([
            'name' => 'Editor',
            'email' => 'editor@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'organization_id' => 1,
        ])->assignRole('editor')
            ->languages()
            ->attach($englishLanguage);

        $roles = Role::all();

        foreach ($roles as $role) {
            $permissions = $role->permissions;
            $users = $role->users;

            foreach ($users as $user) {
                $user->givePermissionTo($permissions);
            }
        }
    }
}
