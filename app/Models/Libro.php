<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor',
        'editorial',
        'anio',
        'estado',
        'categoria_id',
        'sinopsis', 
    ];

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con préstamos (si tienes)
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
