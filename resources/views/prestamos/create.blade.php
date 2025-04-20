<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alquilar libro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e6f0f4] text-[#1a1a1a] font-sans">

    <div class="max-w-2xl mx-auto py-10 px-6">

        {{-- Logo + Título --}}
        <div class="flex items-center justify-center gap-4 mb-8">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo Bibliotech" class="h-16">
            <h1 class="text-3xl font-bold text-[#1e3a8a]">Formulario de Préstamo</h1>
        </div>

        {{-- Errores --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
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
                <label class="block font-medium mb-1">Fecha de recogida</label>
                <input type="date" name="fecha_inicio" class="w-full border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Fecha de devolución</label>
                <input type="date" name="fecha_fin" class="w-full border-gray-300 rounded" required>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('libros.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Cancelar
                </a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Confirmar préstamo
                </button>
            </div>
        </form>
    </div>

</body>
</html>
