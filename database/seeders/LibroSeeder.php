<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('libros')->insert([
            [
                'titulo' => 'Cien años de soledad',
                'autor' => 'Gabriel García Márquez',
                'editorial' => 'Sudamericana',
                'anio' => 1967,
                'sinopsis' => 'La historia épica y mágica de la familia Buendía, cuyos miembros experimentan el amor, la soledad, la violencia y la redención a lo largo de siete generaciones en el mítico pueblo de Macondo. Una novela emblemática del realismo mágico que explora la historia y la cultura latinoamericana desde una perspectiva profundamente humana y poética.',
                'estado' => 'disponible',
                'categoria_id' => 1
            ],
            [
                'titulo' => 'Breve historia del tiempo',
                'autor' => 'Stephen Hawking',
                'editorial' => 'Debate',
                'anio' => 1988,
                'sinopsis' => 'Stephen Hawking nos guía por el universo desde el Big Bang hasta los agujeros negros, haciendo comprensibles los conceptos más complejos de la física moderna. Este libro revolucionó la divulgación científica, acercando temas como el espacio-tiempo, la relatividad o la teoría del todo al público general con un lenguaje accesible y fascinante.',
                'estado' => 'disponible',
                'categoria_id' => 2
            ],
            [
                'titulo' => 'Sapiens: De animales a dioses',
                'autor' => 'Yuval Noah Harari',
                'editorial' => 'Debate',
                'anio' => 2011,
                'sinopsis' => 'Un recorrido provocador y detallado por la historia de la humanidad desde los primeros Homo sapiens hasta la revolución digital. Yuval Noah Harari cuestiona lo que nos define como especie y cómo nuestras decisiones históricas han transformado no solo la sociedad, sino también el entorno natural y nuestra percepción del mundo.',
                'estado' => 'prestado',
                'categoria_id' => 3
            ],
            [
                'titulo' => 'El señor de los anillos',
                'autor' => 'J.R.R. Tolkien',
                'editorial' => 'Minotauro',
                'anio' => 1954,
                'sinopsis' => 'En la vasta Tierra Media, un joven hobbit llamado Frodo se embarca en una peligrosa misión para destruir el Anillo Único, una poderosa reliquia capaz de sumir el mundo en la oscuridad. A través de batallas épicas, alianzas improbables y paisajes inolvidables, esta obra maestra de la fantasía moderna retrata la lucha entre el bien y el mal en su forma más pura.',
                'estado' => 'disponible',
                'categoria_id' => 4
            ],
            [
                'titulo' => 'Los 7 hábitos de la gente altamente efectiva',
                'autor' => 'Stephen R. Covey',
                'editorial' => 'Paidós',
                'anio' => 1989,
                'sinopsis' => 'Stephen R. Covey presenta un enfoque basado en principios atemporales para lograr una vida más efectiva, equilibrada y significativa. Desde la proactividad hasta la sinergia, cada hábito proporciona herramientas prácticas para mejorar las relaciones, la productividad y el liderazgo personal en el ámbito profesional y personal.',
                'estado' => 'reservado',
                'categoria_id' => 5
            ],
            [
                'titulo' => 'Clean Code',
                'autor' => 'Robert C. Martin',
                'editorial' => 'Prentice Hall',
                'anio' => 2008,
                'sinopsis' => 'Un manual esencial para todo programador que desee escribir código claro, eficiente y fácil de mantener. Robert C. Martin expone principios, patrones y prácticas concretas que permiten transformar código confuso en soluciones elegantes, facilitando la colaboración en equipo y el crecimiento de proyectos a largo plazo.',
                'estado' => 'disponible',
                'categoria_id' => 6
            ],
            [
                'titulo' => 'La historia del arte',
                'autor' => 'E. H. Gombrich',
                'editorial' => 'Phaidon',
                'anio' => 1950,
                'sinopsis' => 'Esta obra clásica de E. H. Gombrich ofrece una visión completa y accesible de la evolución del arte desde las pinturas rupestres hasta el arte contemporáneo. A través de un lenguaje claro y apasionado, el autor explora las corrientes artísticas, los grandes maestros y el impacto cultural del arte en cada época.',
                'estado' => 'prestado',
                'categoria_id' => 7
            ],
            [
                'titulo' => 'El poder del ahora',
                'autor' => 'Eckhart Tolle',
                'editorial' => 'Gaia',
                'anio' => 1997,
                'sinopsis' => 'Eckhart Tolle nos invita a liberarnos del sufrimiento emocional y mental mediante el poder transformador de la atención plena al presente. Una guía espiritual profundamente inspiradora que enseña cómo silenciar la mente, dejar atrás el pasado y encontrar la paz interior viviendo conscientemente el aquí y el ahora.',
                'estado' => 'disponible',
                'categoria_id' => 5
            ],
            [
                'titulo' => 'Emociones destructivas',
                'autor' => 'Daniel Goleman',
                'editorial' => 'Kairós',
                'anio' => 2003,
                'sinopsis' => 'Un análisis revelador sobre cómo emociones como la ira, la envidia o el miedo pueden ser comprendidas y transformadas para nuestro bienestar. Daniel Goleman recoge diálogos entre científicos y el Dalai Lama, combinando psicología, neurociencia y sabiduría oriental para ofrecer un enfoque equilibrado al manejo emocional.',
                'estado' => 'disponible',
                'categoria_id' => 8
            ],
            [
                'titulo' => 'El Principito',
                'autor' => 'Antoine de Saint-Exupéry',
                'editorial' => 'Reynal & Hitchcock',
                'anio' => 1943,
                'sinopsis' => 'Esta entrañable fábula filosófica relata las aventuras de un pequeño príncipe que viaja por planetas y conoce personajes que simbolizan aspectos de la vida adulta. A través de una narrativa poética y sencilla, El Principito nos recuerda la importancia de la amistad, la imaginación y lo esencial que solo se ve con el corazón.',
                'estado' => 'disponible',
                'categoria_id' => 9
            ],
        ]);
    }
}
