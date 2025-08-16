<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdiomaController extends Controller
{
    public function cambiar(Request $request)
    {
        // Si el idioma actual es español, lo cambia a inglés. Si no, a español.
        $nuevoIdioma = app()->getLocale() === 'es' ? 'en' : 'es';

        // Guardamos el idioma en la sesión
        session(['locale' => $nuevoIdioma]);

        // Redirigimos atrás (a la página donde estaba el usuario)
        return redirect()->back();
    }
}
