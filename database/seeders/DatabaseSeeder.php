<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsuarioSeeder;
use Database\Seeders\CategoriaSeeder;
use Database\Seeders\LibroSeeder;
use Database\Seeders\PrestamoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            CategoriaSeeder::class,
            LibroSeeder::class,
            PrestamoSeeder::class,
        ]);
    }
}
