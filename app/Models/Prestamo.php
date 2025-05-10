<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
 


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
        return $this->belongsTo(User::class, 'user_id');
    }
    protected $dates = ['fecha_inicio', 'fecha_fin'];
  

public function puedeSerProrrogado()
{
    if (!$this->fecha_fin) return true;

    // Asegurarse de que fecha_inicio sea un objeto Carbon
    $inicio = Carbon::parse($this->fecha_inicio);

    $fechaMaxima = $inicio->copy()->addDays(14); // 7 días iniciales + 7 de prórroga
    return Carbon::parse($this->fecha_fin)->lt($fechaMaxima);
}



    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
