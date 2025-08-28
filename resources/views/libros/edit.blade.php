<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Editar libro') }} - Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      // Forzamos dark mode por clase
      tailwind.config = { darkMode: 'class' };
    </script>
</head>
<body class="font-sans bg-[#e6f0f4] text-[#1a1a1a] dark:bg-slate-900 dark:text-slate-100">

    <div class="max-w-3xl mx-auto py-10 px-6">

        {{-- Cabecera: Logo + Título + Idioma + Tema --}}
        <div class="flex items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-16">
                <h1 class="text-4xl font-extrabold text-[#1e3a8a] dark:text-blue-300 tracking-wide">Bibliotech</h1>
            </div>

            <div class="flex items-center gap-2">
                {{-- Botón idioma --}}
                <form method="POST" action="{{ route('cambiar.idioma') }}">
                    @csrf
                    <button type="submit"
                        class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        🌐 {{ app()->getLocale() === 'es' ? 'English' : 'Español' }}
                    </button>
                </form>
                {{-- Botón tema --}}
                <form method="POST" action="{{ route('tema.toggle') }}">
                    @csrf
                    <button type="submit"
                        class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        @if(session('theme','light') === 'dark')
                          ☀️ {{ __('Tema claro') }}
                        @else
                          🌙 {{ __('Tema oscuro') }}
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-6 text-center">✏️ {{ __('Editar libro') }}</h2>

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-200 p-4 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ route('libros.update', $libro->id) }}" method="POST"
              class="space-y-4 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded p-6 shadow">
            @csrf
            @method('PUT')

            {{-- Título ES --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Título (Español)') }}</label>
                <input type="text" name="titulo" value="{{ old('titulo', $libro->titulo) }}"
                       class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2"
                       required>
            </div>

            {{-- Título EN --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Título (Inglés)') }}</label>
                <input type="text" name="titulo_en" value="{{ old('titulo_en', $libro->titulo_en) }}"
                       class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">
            </div>

            {{-- Autor --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Autor') }}</label>
                <input type="text" name="autor" value="{{ old('autor', $libro->autor) }}"
                       class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">
            </div>

            {{-- Editorial --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Editorial') }}</label>
                <input type="text" name="editorial" value="{{ old('editorial', $libro->editorial) }}"
                       class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">
            </div>

            {{-- Año --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Año') }}</label>
                <input type="number" name="anio" value="{{ old('anio', $libro->anio) }}"
                       class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">
            </div>

            {{-- Estado --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Estado') }}</label>
                <select name="estado"
                        class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">
                    <option value="disponible" @selected(old('estado', $libro->estado) === 'disponible')>{{ __('Disponible') }}</option>
                    <option value="prestado"   @selected(old('estado', $libro->estado) === 'prestado')>{{ __('Prestado') }}</option>
                    <option value="reservado"  @selected(old('estado', $libro->estado) === 'reservado')>{{ __('Reservado') }}</option>
                </select>
            </div>

            {{-- Categoría --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Categoría') }}</label>
                <select name="categoria_id"
                        class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(old('categoria_id', $libro->categoria_id) == $categoria->id)>
                            {{ app()->getLocale() === 'en' && $categoria->nombre_en ? $categoria->nombre_en : $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sinopsis ES --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Sinopsis (Español)') }}</label>
                <textarea name="sinopsis" rows="4"
                          class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">{{ old('sinopsis', $libro->sinopsis) }}</textarea>
            </div>

            {{-- Sinopsis EN --}}
            <div>
                <label class="block font-medium mb-1">{{ __('Sinopsis (Inglés)') }}</label>
                <textarea name="sinopsis_en" rows="4"
                          class="w-full rounded border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3 py-2">{{ old('sinopsis_en', $libro->sinopsis_en) }}</textarea>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('libros.index') }}"
                   class="bg-gray-400 dark:bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500 dark:hover:bg-gray-500">
                    {{ __('Cancelar') }}
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    {{ __('Actualizar') }}
                </button>
            </div>
        </form>
    </div>

</body>
</html>
