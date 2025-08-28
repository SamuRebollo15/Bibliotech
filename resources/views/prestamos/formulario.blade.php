<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Alquilar libro') }} - {{ $libro->titulo_localizado }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
</head>
<body class="bg-gray-100 dark:bg-slate-900 min-h-screen flex items-center justify-center px-4 text-slate-900 dark:text-slate-100 font-sans">

    <div class="absolute top-4 right-4 flex gap-2">
        {{-- Botón idioma --}}
        <form method="POST" action="{{ route('cambiar.idioma') }}">
            @csrf
            <button type="submit"
                class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-gray-800
                       dark:bg-gray-700 dark:text-slate-100 dark:hover:bg-gray-600 transition">
                🌐 {{ app()->getLocale() === 'es' ? 'English' : 'Español' }}
            </button>
        </form>
        {{-- Botón tema --}}
        <form method="POST" action="{{ route('tema.toggle') }}">
            @csrf
            <button type="submit"
                class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-gray-800
                       dark:bg-gray-700 dark:text-slate-100 dark:hover:bg-gray-600 transition">
                @if(session('theme','light') === 'dark')
                    ☀️ {{ __('Tema claro') }}
                @else
                    🌙 {{ __('Tema oscuro') }}
                @endif
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-8 w-full max-w-lg border border-gray-200 dark:border-slate-700">
        {{-- Logo y encabezado --}}
        <div class="flex items-center justify-center gap-4 mb-6">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo" class="h-12">
            <h1 class="text-2xl font-bold text-blue-800 dark:text-blue-300">{{ __('Alquilar libro') }}</h1>
        </div>

        {{-- Nombre del libro (localizado) --}}
        <h2 class="text-xl font-semibold text-center mb-4">📚 {{ $libro->titulo_localizado }}</h2>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 p-4 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('prestamos.realizar', $libro->id) }}">
            @csrf

            {{-- Fecha de recogida --}}
            <div class="mb-4">
                <label class="block font-medium mb-1" for="fecha_inicio">📅 {{ __('Fecha de recogida') }}</label>
                <input
                    type="date"
                    name="fecha_inicio"
                    id="fecha_inicio"
                    class="w-full border rounded px-3 py-2 bg-white dark:bg-slate-900 border-gray-300 dark:border-slate-600"
                    value="{{ $fechaRecogida->format('Y-m-d') }}"
                    min="{{ $fechaRecogida->format('Y-m-d') }}"
                    required
                >
            </div>

            {{-- Fecha de devolución (solo lectura) --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">📅 {{ __('Fecha de devolución') }}</label>
                <input
                    type="date"
                    class="w-full border rounded px-3 py-2 bg-gray-100 dark:bg-slate-900 cursor-not-allowed border-gray-300 dark:border-slate-600"
                    value="{{ $fechaDevolucion->format('Y-m-d') }}"
                    readonly
                >
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">
                    {{ __('La fecha de devolución se calcula automáticamente (:days días después de la recogida).', ['days' => 25]) }}
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between">
                <a href="{{ route('libros.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    {{ __('Cancelar') }}
                </a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    {{ __('Confirmar préstamo') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Script para actualizar fecha de devolución si cambia la recogida --}}
    <script>
        document.getElementById('fecha_inicio').addEventListener('change', function() {
            let fechaInicio = new Date(this.value);
            if (!isNaN(fechaInicio)) {
                let fechaFin = new Date(fechaInicio);
                fechaFin.setDate(fechaFin.getDate() + 25); // 25 días
                let fechaFinStr = fechaFin.toISOString().split('T')[0];
                document.querySelector('input[readonly]').value = fechaFinStr;
            }
        });
    </script>

</body>
</html>
