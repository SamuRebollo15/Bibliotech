<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    

    protected $fillable = [
        'name',      // nombre del usuario
        'email',     // correo electrónico
        'password',  // contraseña hasheada
        'rol',       // admin o lector
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación: un usuario puede tener muchos préstamos
    public function prestamos()
{
    return $this->hasMany(Prestamo::class, 'user_id');
}


    // Método para verificar si el usuario es administrador
    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }
    
    
}
