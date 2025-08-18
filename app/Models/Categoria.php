<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'nombre_en', // nuevo
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'categoria_id');
    }

    // Accessor para mostrar el nombre según idioma
    public function getNombreLocalizadoAttribute(): string
    {
        return app()->getLocale() === 'en' && $this->nombre_en
            ? $this->nombre_en
            : $this->nombre;
    }
}
