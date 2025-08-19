<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Editar perfil') }} | Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e6f0f4] text-gray-800 font-sans">
    <div class="max-w-2xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-center text-[#1e3a8a] mb-8">✏️ {{ __('Editar perfil') }}</h1>

        {{-- Mensajes --}}
        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif

        {{-- Errores --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">{{ __('Nombre') }}</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                    class="w-full border px-3 py-2 rounded">
            </div>

            {{-- Correo --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">{{ __('Correo electrónico') }}</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                    class="w-full border px-3 py-2 rounded">
            </div>

            {{-- Contraseña --}}
            <div class="mb-6">
                <label class="block font-semibold mb-1">{{ __('Nueva contraseña (opcional)') }}</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded">
                <p class="text-sm text-gray-500 mt-1">{{ __('Déjalo en blanco si no deseas cambiarla.') }}</p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('cuenta.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                    {{ __('Volver') }}
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    {{ __('Guardar cambios') }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
