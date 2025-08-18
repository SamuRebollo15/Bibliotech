<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Novela',      'nombre_en' => 'Novel'],
            ['nombre' => 'Ciencia',     'nombre_en' => 'Science'],
            ['nombre' => 'Historia',    'nombre_en' => 'History'],
            ['nombre' => 'Fantasía',    'nombre_en' => 'Fantasy'],
            ['nombre' => 'Autoayuda',   'nombre_en' => 'Self-help'],
            ['nombre' => 'Tecnología',  'nombre_en' => 'Technology'],
            ['nombre' => 'Arte',        'nombre_en' => 'Art'],
            ['nombre' => 'Psicología',  'nombre_en' => 'Psychology'],
            ['nombre' => 'Infantil',    'nombre_en' => 'Children'],
            ['nombre' => 'Cómic',       'nombre_en' => 'Comic'],
        ];

        // Inserta nuevas o actualiza el campo nombre_en si ya existe ese 'nombre'
        DB::table('categorias')->upsert(
            $categorias,
            ['nombre'],          
            ['nombre_en']        
        );
    }
}
