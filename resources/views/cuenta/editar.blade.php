<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Editar perfil') }} | Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
</head>

<body class="font-sans bg-[#e6f0f4] text-gray-800 dark:bg-slate-900 dark:text-slate-100">
    <div class="max-w-2xl mx-auto px-4 py-10">

        {{-- Barra de controles (idioma + tema) --}}
        <div class="flex justify-end gap-2 mb-4">
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

        <h1 class="text-3xl font-bold text-center text-[#1e3a8a] dark:text-blue-300 mb-8">
            ✏️ {{ __('Editar perfil') }}
        </h1>

        {{-- Mensajes --}}
        @if (session('status'))
            <div class="bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 p-4 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif

        {{-- Errores --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}"
              class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded p-6">
            @csrf
            @method('PATCH')

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">{{ __('Nombre') }}</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                    class="w-full border rounded px-3 py-2
                           border-gray-300 bg-white text-gray-900
                           dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100">
            </div>

            {{-- Correo --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">{{ __('Correo electrónico') }}</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                    class="w-full border rounded px-3 py-2
                           border-gray-300 bg-white text-gray-900
                           dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100">
            </div>

            {{-- Contraseña --}}
            <div class="mb-6">
                <label class="block font-semibold mb-1">{{ __('Nueva contraseña (opcional)') }}</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2
                           border-gray-300 bg-white text-gray-900
                           dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100">
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                    {{ __('Déjalo en blanco si no deseas cambiarla.') }}
                </p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('cuenta.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition">
                    {{ __('Volver') }}
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                    {{ __('Guardar cambios') }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
