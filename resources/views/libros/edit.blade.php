<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Editar libro') }} - Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e6f0f4] text-[#1a1a1a] font-sans">

    <div class="max-w-3xl mx-auto py-10 px-6">

        {{-- Logo + Título --}}
        <div class="flex items-center justify-center gap-4 mb-8">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-16">
            <h1 class="text-4xl font-extrabold text-[#1e3a8a] tracking-wide">Bibliotech</h1>
        </div>

        <h2 class="text-2xl font-semibold mb-6 text-center">✏️ {{ __('Editar libro') }}</h2>

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ route('libros.update', $libro->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Título ES --}}
            <div>
                <label class="block font-medium">{{ __('Título (Español)') }}</label>
                <input type="text" name="titulo" value="{{ old('titulo', $libro->titulo) }}" class="w-full rounded border-gray-300" required>
            </div>

            {{-- Título EN (opcional) --}}
            <div>
                <label class="block font-medium">{{ __('Título (Inglés)') }}</label>
                <input type="text" name="titulo_en" value="{{ old('titulo_en', $libro->titulo_en) }}" class="w-full rounded border-gray-300">
            </div>

            {{-- Autor --}}
            <div>
                <label class="block font-medium">{{ __('Autor') }}</label>
                <input type="text" name="autor" value="{{ old('autor', $libro->autor) }}" class="w-full rounded border-gray-300">
            </div>

            {{-- Editorial --}}
            <div>
                <label class="block font-medium">{{ __('Editorial') }}</label>
                <input type="text" name="editorial" value="{{ old('editorial', $libro->editorial) }}" class="w-full rounded border-gray-300">
            </div>

            {{-- Año --}}
            <div>
                <label class="block font-medium">{{ __('Año') }}</label>
                <input type="number" name="anio" value="{{ old('anio', $libro->anio) }}" class="w-full rounded border-gray-300">
            </div>

            {{-- Estado --}}
            <div>
                <label class="block font-medium">{{ __('Estado') }}</label>
                <select name="estado" class="w-full rounded border-gray-300">
                    <option value="disponible" @selected(old('estado', $libro->estado) === 'disponible')>{{ __('Disponible') }}</option>
                    <option value="prestado" @selected(old('estado', $libro->estado) === 'prestado')>{{ __('Prestado') }}</option>
                    <option value="reservado" @selected(old('estado', $libro->estado) === 'reservado')>{{ __('Reservado') }}</option>
                </select>
            </div>

            {{-- Categoría --}}
            <div>
                <label class="block font-medium">{{ __('Categoría') }}</label>
                <select name="categoria_id" class="w-full rounded border-gray-300">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(old('categoria_id', $libro->categoria_id) == $categoria->id)>
                            {{ app()->getLocale() === 'en' && $categoria->nombre_en ? $categoria->nombre_en : $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sinopsis ES --}}
            <div>
                <label class="block font-medium">{{ __('Sinopsis (Español)') }}</label>
                <textarea name="sinopsis" rows="4" class="w-full rounded border-gray-300">{{ old('sinopsis', $libro->sinopsis) }}</textarea>
            </div>

            {{-- Sinopsis EN (opcional) --}}
            <div>
                <label class="block font-medium">{{ __('Sinopsis (Inglés)') }}</label>
                <textarea name="sinopsis_en" rows="4" class="w-full rounded border-gray-300">{{ old('sinopsis_en', $libro->sinopsis_en) }}</textarea>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('libros.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">{{ __('Cancelar') }}</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">{{ __('Actualizar') }}</button>
            </div>
        </form>
    </div>

</body>
</html>
    