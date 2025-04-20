<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Laura Pérez', 'email' => 'laura@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'Carlos Ruiz', 'email' => 'carlos@example.com', 'password' => Hash::make('password'), 'rol' => 'admin'],
            ['name' => 'Ana Gómez', 'email' => 'ana@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'Pedro Sánchez', 'email' => 'pedro@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'Marta Díaz', 'email' => 'marta@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'Iván Ramírez', 'email' => 'ivan@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'Sofía Blanco', 'email' => 'sofia@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'Daniel Ortega', 'email' => 'daniel@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'Lucía Torres', 'email' => 'lucia@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
            ['name' => 'José Martínez', 'email' => 'jose@example.com', 'password' => Hash::make('password'), 'rol' => 'lector'],
        ]);
    }
}
