<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'titulo_en',   // nuevo
        'autor',
        'editorial',
        'anio',
        'estado',
        'categoria_id',
        'sinopsis',
        'sinopsis_en', // nuevo
    ];

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    // Accessors: devuelven el texto según idioma actual
    public function getTituloLocalizadoAttribute(): string
    {
        return app()->getLocale() === 'en' && $this->titulo_en
            ? $this->titulo_en
            : $this->titulo;
    }

    public function getSinopsisLocalizadaAttribute(): ?string
    {
        return app()->getLocale() === 'en' && $this->sinopsis_en
            ? $this->sinopsis_en
            : $this->sinopsis;
    }
}
