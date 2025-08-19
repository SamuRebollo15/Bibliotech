<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('Mi Cuenta') }} | Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e6f0f4] text-gray-800 font-sans">

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Encabezado --}}
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-[#1e3a8a] mb-2">👤 {{ __('Mi Cuenta') }}</h1>
            <p class="text-gray-600">
                {{ __('Bienvenido/a, :name. Aquí puedes gestionar tus opciones.', ['name' => Auth::user()->name]) }}
            </p>
        </div>

        {{-- Tarjetas de opciones --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @if(Auth::user()->esAdmin())
            {{-- 🔒 Opciones exclusivas para administradores --}}
            <div class="bg-white rounded-lg shadow-md p-6 border hover:shadow-lg transition">
                <h2 class="text-lg font-bold text-[#1e3a8a] mb-2">📋 {{ __('Gestión de préstamos') }}</h2>
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('Consulta y administra todos los préstamos del sistema.') }}
                </p>
                <a href="{{ route('admin.prestamos.gestion') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    {{ __('Acceder') }}
                </a>
            </div>

            {{-- Aquí podrías añadir más tarjetas para admins en el futuro --}}
            @else
            {{-- 👤 Opciones para usuarios lectores --}}
            <div class="bg-white rounded-lg shadow-md p-6 border hover:shadow-lg transition">
                <h2 class="text-lg font-bold text-[#1e3a8a] mb-2">📚 {{ __('Ver préstamos activos') }}</h2>
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('Consulta los libros que tienes actualmente en préstamo.') }}
                </p>
                <a href="{{ route('prestamos.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    {{ __('Acceder') }}
                </a>
            </div>
            @endif

            {{-- Editar perfil (común para ambos roles) --}}
            <div class="bg-white rounded-lg shadow-md p-6 border hover:shadow-lg transition">
                <h2 class="text-lg font-bold text-[#1e3a8a] mb-2">⚙️ {{ __('Editar perfil') }}</h2>
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('Modifica tu nombre, correo o contraseña.') }}
                </p>
                <a href="{{ route('profile.edit') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    {{ __('Editar') }}
                </a>
            </div>

        </div>

        {{-- Botones inferiores --}}
        <div class="mt-10 flex justify-center gap-4">
            <a href="{{ route('libros.index') }}"
                class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
                ← {{ __('Volver al catálogo') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                    {{ __('Cerrar sesión') }}
                </button>
            </form>
        </div>

    </div>

</body>

</html>