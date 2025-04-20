<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Novela'],
            ['nombre' => 'Ciencia'],
            ['nombre' => 'Historia'],
            ['nombre' => 'Fantasía'],
            ['nombre' => 'Autoayuda'],
            ['nombre' => 'Tecnología'],
            ['nombre' => 'Arte'],
            ['nombre' => 'Psicología'],
            ['nombre' => 'Infantil'],
            ['nombre' => 'Cómic'],
        ]);
    }
}
