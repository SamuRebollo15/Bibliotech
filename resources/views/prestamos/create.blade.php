<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Formulario de Préstamo') }} | Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
</head>
<body class="bg-[#e6f0f4] text-[#1a1a1a] dark:bg-slate-900 dark:text-slate-100 font-sans">

    <div class="max-w-2xl mx-auto py-10 px-6">

        {{-- Controles: idioma + tema --}}
        <div class="flex justify-end gap-2 mb-6">
            <form method="POST" action="{{ route('cambiar.idioma') }}">
                @csrf
                <button type="submit"
                    class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-gray-800
                           dark:bg-gray-700 dark:text-slate-100 dark:hover:bg-gray-600 transition">
                    🌐 {{ app()->getLocale() === 'es' ? 'English' : 'Español' }}
                </button>
            </form>
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

        {{-- Logo + Título --}}
        <div class="flex items-center justify-center gap-4 mb-8">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-16">
            <h1 class="text-3xl font-bold text-[#1e3a8a] dark:text-blue-300">
                {{ __('Formulario de Préstamo') }}
            </h1>
        </div>

        {{-- Errores --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('prestamos.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="libro_id" value="{{ $libro->id }}">

            <div>
                <label class="block font-medium mb-1">{{ __('Fecha de recogida') }}</label>
                <input type="date" name="fecha_inicio"
                       class="w-full border-gray-300 rounded dark:bg-slate-800 dark:border-slate-600 dark:text-slate-100"
                       required>
            </div>

            <div>
                <label class="block font-medium mb-1">{{ __('Fecha de devolución') }}</label>
                <input type="date" name="fecha_fin"
                       class="w-full border-gray-300 rounded dark:bg-slate-800 dark:border-slate-600 dark:text-slate-100"
                       required>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('libros.index') }}"
                   class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 dark:bg-gray-600 dark:hover:bg-gray-700">
                    {{ __('Cancelar') }}
                </a>
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800">
                    {{ __('Confirmar préstamo') }}
                </button>
            </div>
        </form>
    </div>

</body>
</html>
