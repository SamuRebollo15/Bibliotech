<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestamo;
use App\Models\User;

class CuentaController extends Controller
{
    public function index()
{
    $usuario = Auth::user();
    return view('cuenta.index', compact('usuario'));
}

public function prestamos()
{
    $usuario = Auth::user();
    $prestamosActivos = $usuario->prestamos()->where('estado', 'activo')->with('libro')->get();

    return view('cuenta.prestamos', compact('usuario', 'prestamosActivos'));
}

}
