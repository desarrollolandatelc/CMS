<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $administrator = Role::create(['name' => 'administrador']);

        // Create Administrator role
        $developer = Role::create(['name' => 'desarrollador']);

        // Create Client role
        Role::create(['name' => 'cliente']);

        // Creamos un usuario
        $administratorUser = User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password123+_'),
            'email_verified_at' => now(),
        ]);

        $developerUser = User::create([
            'name' => 'Developer',
            'email' => 'developer@mail.com',
            'password' => bcrypt('password123+*'),
            'email_verified_at' => now(),
        ]);

        // Asignamos el rol al usuario
        $administratorUser->assignRole($administrator);
    }
}
