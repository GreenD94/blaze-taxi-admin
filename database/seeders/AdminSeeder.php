<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Crear o encontrar el rol de admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear el usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin123'), // Nueva contraseña
                'contact_number' => '+593992587744',
                'user_type' => 'admin',
                'status' => 'active',
                'timezone' => 'America/Caracas'
            ]
        );

        // Asignar rol de admin
        $admin->assignRole($adminRole);
    }
} 