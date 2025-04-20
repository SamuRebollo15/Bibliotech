<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alquilar libro - {{ $libro->titulo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-lg">
        {{-- Logo y encabezado --}}
        <div class="flex items-center justify-center gap-4 mb-6">
            <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="Logo" class="h-12">
            <h1 class="text-2xl font-bold text-blue-800">Alquilar libro</h1>
        </div>

        {{-- Nombre del libro --}}
        <h2 class="text-xl font-semibold text-center mb-4">📚 {{ $libro->titulo }}</h2>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4 text-sm">
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

            <div class="mb-4">
                <label class="block font-medium mb-1" for="fecha_inicio">📅 Fecha de recogida</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-6">
                <label class="block font-medium mb-1" for="fecha_fin">📅 Fecha de devolución</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('libros.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Confirmar préstamo</button>
            </div>
        </form>
    </div>

</body>
</html>
