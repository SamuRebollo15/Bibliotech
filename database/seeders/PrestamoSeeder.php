<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestamoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prestamos')->insert([
            ['usuario_id' => 1, 'libro_id' => 3, 'fecha_inicio' => '2025-04-01', 'fecha_fin' => '2025-04-15', 'estado' => 'activo'],
            ['usuario_id' => 4, 'libro_id' => 7, 'fecha_inicio' => '2025-04-10', 'fecha_fin' => null, 'estado' => 'activo'],
            ['usuario_id' => 5, 'libro_id' => 2, 'fecha_inicio' => '2025-04-05', 'fecha_fin' => '2025-04-13', 'estado' => 'devuelto'],
            ['usuario_id' => 2, 'libro_id' => 5, 'fecha_inicio' => '2025-04-07', 'fecha_fin' => null, 'estado' => 'activo'],
            ['usuario_id' => 3, 'libro_id' => 6, 'fecha_inicio' => '2025-04-03', 'fecha_fin' => null, 'estado' => 'activo'],
            ['usuario_id' => 6, 'libro_id' => 1, 'fecha_inicio' => '2025-04-12', 'fecha_fin' => null, 'estado' => 'activo'],
            ['usuario_id' => 7, 'libro_id' => 8, 'fecha_inicio' => '2025-04-11', 'fecha_fin' => '2025-04-18', 'estado' => 'devuelto'],
            ['usuario_id' => 8, 'libro_id' => 10, 'fecha_inicio' => '2025-04-02', 'fecha_fin' => '2025-04-09', 'estado' => 'devuelto'],
            ['usuario_id' => 9, 'libro_id' => 4, 'fecha_inicio' => '2025-04-14', 'fecha_fin' => null, 'estado' => 'activo'],
            ['usuario_id' => 10, 'libro_id' => 9, 'fecha_inicio' => '2025-04-13', 'fecha_fin' => null, 'estado' => 'activo'],
        ]);
    }
}
