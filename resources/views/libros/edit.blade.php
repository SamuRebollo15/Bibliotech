<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar libro - Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e6f0f4] text-[#1a1a1a] font-sans">

    <div class="max-w-3xl mx-auto py-10 px-6">

        {{-- Logo + Título --}}
        <div class="flex items-center justify-center gap-4 mb-8">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-16">
            <h1 class="text-4xl font-extrabold text-[#1e3a8a] tracking-wide">Bibliotech</h1>
        </div>

        <h2 class="text-2xl font-semibold mb-6 text-center">✏️ Editar libro</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('libros.update', $libro->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Título</label>
                <input type="text" name="titulo" value="{{ $libro->titulo }}" class="w-full rounded border-gray-300" required>
            </div>

            <div>
                <label class="block font-medium">Autor</label>
                <input type="text" name="autor" value="{{ $libro->autor }}" class="w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block font-medium">Editorial</label>
                <input type="text" name="editorial" value="{{ $libro->editorial }}" class="w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block font-medium">Año</label>
                <input type="number" name="anio" value="{{ $libro->anio }}" class="w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block font-medium">Estado</label>
                <select name="estado" class="w-full rounded border-gray-300">
                    <option value="disponible" @selected($libro->estado == 'disponible')>Disponible</option>
                    <option value="prestado" @selected($libro->estado == 'prestado')>Prestado</option>
                    <option value="reservado" @selected($libro->estado == 'reservado')>Reservado</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Categoría</label>
                <select name="categoria_id" class="w-full rounded border-gray-300">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected($categoria->id == $libro->categoria_id)>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium">Sinopsis</label>
                <textarea name="sinopsis" rows="4" class="w-full rounded border-gray-300">{{ $libro->sinopsis }}</textarea>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('libros.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
            </div>
        </form>
    </div>

</body>
</html>

