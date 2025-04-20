<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';

    protected $fillable = [
        'user_id',
        'libro_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
