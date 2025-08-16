<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetIdioma
{
    /**
     * Manejar la petición entrante.
     */
    public function handle($request, Closure $next)
    {
        // Leer el idioma de la sesión, si no existe usar 'es'
        $locale = session('locale', 'es');

        // Aplicar el idioma a la aplicación
        App::setLocale($locale);

        return $next($request);
    }
}
