<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        $libros = [
            [
                'titulo'      => 'Cien años de soledad',
                'titulo_en'   => 'One Hundred Years of Solitude',
                'autor'       => 'Gabriel García Márquez',
                'editorial'   => 'Sudamericana',
                'anio'        => 1967,
                'sinopsis'    => 'La historia épica y mágica de la familia Buendía, cuyos miembros experimentan el amor, la soledad, la violencia y la redención a lo largo de siete generaciones en el mítico pueblo de Macondo...',
                'sinopsis_en' => 'The epic, magical saga of the Buendía family across seven generations in the mythical town of Macondo, exploring love, solitude, violence, and redemption—a landmark of magical realism and Latin American culture.',
                'estado'      => 'disponible',
                'categoria_id'=> 1,
            ],
            [
                'titulo'      => 'Breve historia del tiempo',
                'titulo_en'   => 'A Brief History of Time',
                'autor'       => 'Stephen Hawking',
                'editorial'   => 'Debate',
                'anio'        => 1988,
                'sinopsis'    => 'Stephen Hawking nos guía por el universo desde el Big Bang hasta los agujeros negros...',
                'sinopsis_en' => 'Stephen Hawking guides readers from the Big Bang to black holes, making modern physics—space-time, relativity, and the search for a unified theory—accessible and fascinating.',
                'estado'      => 'disponible',
                'categoria_id'=> 2,
            ],
            [
                'titulo'      => 'Sapiens: De animales a dioses',
                'titulo_en'   => 'Sapiens: A Brief History of Humankind',
                'autor'       => 'Yuval Noah Harari',
                'editorial'   => 'Debate',
                'anio'        => 2011,
                'sinopsis'    => 'Un recorrido provocador y detallado por la historia de la humanidad desde los primeros Homo sapiens...',
                'sinopsis_en' => 'A provocative journey through human history, from early Homo sapiens to the digital age, questioning what defines us and how our choices reshaped society and the planet.',
                'estado'      => 'prestado',
                'categoria_id'=> 3,
            ],
            [
                'titulo'      => 'El señor de los anillos',
                'titulo_en'   => 'The Lord of the Rings',
                'autor'       => 'J.R.R. Tolkien',
                'editorial'   => 'Minotauro',
                'anio'        => 1954,
                'sinopsis'    => 'En la vasta Tierra Media, un joven hobbit llamado Frodo se embarca en una peligrosa misión...',
                'sinopsis_en' => 'In Middle-earth, the hobbit Frodo undertakes a perilous quest to destroy the One Ring, an epic tale of courage, friendship, and the struggle between good and evil.',
                'estado'      => 'disponible',
                'categoria_id'=> 4,
            ],
            [
                'titulo'      => 'Los 7 hábitos de la gente altamente efectiva',
                'titulo_en'   => 'The 7 Habits of Highly Effective People',
                'autor'       => 'Stephen R. Covey',
                'editorial'   => 'Paidós',
                'anio'        => 1989,
                'sinopsis'    => 'Stephen R. Covey presenta un enfoque basado en principios atemporales para lograr una vida más efectiva...',
                'sinopsis_en' => 'Stephen R. Covey presents timeless, principle-centered habits—from proactivity to synergy—to improve productivity, relationships, and personal leadership.',
                'estado'      => 'reservado',
                'categoria_id'=> 5,
            ],
            [
                'titulo'      => 'Clean Code',
                'titulo_en'   => 'Clean Code',
                'autor'       => 'Robert C. Martin',
                'editorial'   => 'Prentice Hall',
                'anio'        => 2008,
                'sinopsis'    => 'Un manual esencial para escribir código claro, eficiente y fácil de mantener...',
                'sinopsis_en' => 'An essential guide to writing clear, efficient, and maintainable code, with principles, patterns, and practices for long-term, collaborative software.',
                'estado'      => 'disponible',
                'categoria_id'=> 6,
            ],
            [
                'titulo'      => 'La historia del arte',
                'titulo_en'   => 'The Story of Art',
                'autor'       => 'E. H. Gombrich',
                'editorial'   => 'Phaidon',
                'anio'        => 1950,
                'sinopsis'    => 'Una visión completa y accesible de la evolución del arte desde las pinturas rupestres hasta el arte contemporáneo...',
                'sinopsis_en' => 'A clear, accessible overview of art history from cave paintings to contemporary art, covering movements, masters, and cultural impact.',
                'estado'      => 'prestado',
                'categoria_id'=> 7,
            ],
            [
                'titulo'      => 'El poder del ahora',
                'titulo_en'   => 'The Power of Now',
                'autor'       => 'Eckhart Tolle',
                'editorial'   => 'Gaia',
                'anio'        => 1997,
                'sinopsis'    => 'Una guía espiritual que enseña cómo vivir conscientemente el presente para liberarse del sufrimiento...',
                'sinopsis_en' => 'A spiritual guide to living consciously in the present moment, quieting the mind, and finding inner peace beyond past and future.',
                'estado'      => 'disponible',
                'categoria_id'=> 5,
            ],
            [
                'titulo'      => 'Emociones destructivas',
                'titulo_en'   => 'Destructive Emotions',
                'autor'       => 'Daniel Goleman',
                'editorial'   => 'Kairós',
                'anio'        => 2003,
                'sinopsis'    => 'Un análisis sobre cómo emociones como la ira o el miedo pueden comprenderse y transformarse...',
                'sinopsis_en' => 'An exploration of how emotions like anger and fear can be understood and transformed, blending psychology, neuroscience, and dialogues with the Dalai Lama.',
                'estado'      => 'disponible',
                'categoria_id'=> 8,
            ],
            [
                'titulo'      => 'El Principito',
                'titulo_en'   => 'The Little Prince',
                'autor'       => 'Antoine de Saint-Exupéry',
                'editorial'   => 'Reynal & Hitchcock',
                'anio'        => 1943,
                'sinopsis'    => 'Una fábula filosófica sobre un pequeño príncipe que viaja por planetas y aprende sobre la vida y la amistad...',
                'sinopsis_en' => 'A philosophical fable about a little prince who travels between planets, discovering friendship, imagination, and the essentials seen only with the heart.',
                'estado'      => 'disponible',
                'categoria_id'=> 9,
            ],
        ];

        foreach ($libros as $libro) {
            DB::table('libros')->updateOrInsert(
                // Criterio para encontrar el registro existente:
                ['titulo' => $libro['titulo'], 'autor' => $libro['autor']],
                // Valores a insertar/actualizar:
                $libro
            );
        }
    }
}
