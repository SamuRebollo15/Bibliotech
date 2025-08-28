<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" class="{{ session('theme','light') === 'dark' ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8" />
    <title>Bibliotech</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{--  forzar darkMode por clase cuando usamos el CDN --}}
    <script>
      tailwind.config = { darkMode: 'class' };
    </script>
</head>

<body class="font-sans
             bg-[#e6f0f4] text-[#1a1a1a]
             dark:bg-slate-900 dark:text-slate-100">

    {{-- Toast de éxito --}}
    @if(session('success'))
      <div id="toast"
           class="fixed top-4 left-1/2 -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50 transition-opacity duration-300">
          {{ session('success') }}
      </div>
      <script>
        setTimeout(() => document.getElementById('toast')?.style && (document.getElementById('toast').style.opacity = '0'), 3000);
      </script>
    @endif

    <div class="max-w-6xl mx-auto py-8 px-4">

        {{-- Logo + Nombre + Autenticación + Idioma + Tema --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/logo_bibliotech.png') }}" alt="{{ __('Logo Bibliotech') }}" class="h-16">
                <h1 class="text-4xl font-extrabold text-[#1e3a8a] dark:text-blue-300 tracking-wide">Bibliotech</h1>
            </div>

            <div class="flex items-center gap-3">
                {{-- Botón de idioma --}}
                <form method="POST" action="{{ route('cambiar.idioma') }}">
                    @csrf
                    <button type="submit"
                        class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        🌐 {{ app()->getLocale() === 'es' ? 'English' : 'Español' }}
                    </button>
                </form>

                {{-- Botón de tema (claro/oscuro) --}}
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

                @auth
                  <a href="{{ route('cuenta.index') }}"
                     class="text-[#1e3a8a] dark:text-blue-300 font-semibold hover:underline hover:text-[#3b82f6] dark:hover:text-blue-200 transition">
                      {{ Auth::user()->name }}
                  </a>
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit"
                              class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition shadow">
                          {{ __('Cerrar sesión') }}
                      </button>
                  </form>
                @else
                  <a href="{{ route('login') }}"
                     class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition shadow">
                     {{ __('Iniciar sesión') }}
                  </a>
                  <a href="{{ route('register') }}"
                     class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition shadow">
                     {{ __('Registrarse') }}
                  </a>
                @endauth
            </div>
        </div>

        {{-- Botón para añadir nuevo libro (solo admin) --}}
        @auth
        @if(Auth::user()->esAdmin())
        <div class="flex justify-end mb-4">
            <a href="{{ route('libros.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                ➕ {{ __('Añadir nuevo libro') }}
            </a>
        </div>
        @endif
        @endauth

        {{-- Buscador --}}
        <form method="GET" action="{{ route('libros.index') }}"
              class="mb-6 bg-white dark:bg-slate-800 p-4 rounded shadow border border-gray-200 dark:border-slate-700">
            <div class="flex items-center gap-4">
                <input type="text" name="busqueda" placeholder="{{ __('Buscar por título o autor') }}"
                       value="{{ request('busqueda') }}"
                       class="flex-grow px-4 py-2 border rounded border-gray-300 dark:border-slate-600
                              bg-white dark:bg-slate-900
                              placeholder-gray-500 dark:placeholder-slate-400
                              focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    {{ __('Buscar') }}
                </button>
                @if(request('busqueda'))
                  <a href="{{ route('libros.index') }}"
                     class="text-red-600 dark:text-red-400 underline text-sm hover:text-red-800 dark:hover:text-red-300">
                      {{ __('Limpiar') }}
                  </a>
                @endif
            </div>
        </form>

        {{-- Tabla de libros --}}
        <div class="bg-white dark:bg-slate-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-slate-700">
            <table class="w-full text-left table-auto">
                <thead class="bg-[#1e3a8a] dark:bg-slate-700 text-white">
                    <tr>
                        <th class="py-3 px-4">{{ __('Título') }}</th>
                        <th class="py-3 px-4">{{ __('Autor') }}</th>
                        <th class="py-3 px-4">{{ __('Estado') }}</th>
                        <th class="py-3 px-4 text-center">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($libros as $libro)
                    <tr class="border-t border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/40">
                        <td class="py-3 px-4 font-medium">{{ $libro->titulo_localizado }}</td>
                        <td class="py-3 px-4">{{ $libro->autor }}</td>
                        <td class="py-3 px-4">
                            @if($libro->estado === 'disponible')
                                <span class="text-green-600 dark:text-green-400 font-semibold">{{ __('Disponible') }}</span>
                            @elseif($libro->estado === 'prestado')
                                <span class="text-red-600 dark:text-red-400 font-semibold">{{ __('Prestado') }}</span>
                            @else
                                <span class="text-yellow-600 dark:text-yellow-400 font-semibold">{{ __('Reservado') }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center space-x-2">
                            <a href="{{ route('libros.show', $libro->id) }}"
                               class="bg-[#1e3a8a] dark:bg-slate-600 text-white px-3 py-1 rounded text-sm hover:bg-[#3b82f6] dark:hover:bg-slate-500 transition">
                                {{ __('Ver') }}
                            </a>
                            @auth
                            @if(Auth::user()->esAdmin())
                              <a href="{{ route('libros.edit', $libro->id) }}"
                                 class="bg-yellow-500 text-white text-sm px-3 py-1 rounded hover:bg-yellow-600 transition">
                                  {{ __('Editar') }}
                              </a>
                              <button type="button"
                                      onclick="openModal({{ $libro->id }})"
                                      class="bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700 transition">
                                  {{ __('Eliminar') }}
                              </button>
                            @endif
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal de confirmación --}}
    <div id="deleteModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-slate-800 rounded-lg p-6 w-full max-w-md border border-gray-200 dark:border-slate-700 shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-center">{{ __('¿Estás seguro?') }}</h2>
            <p class="mb-6 text-center">{{ __('Esta acción eliminará el libro permanentemente.') }}</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()"
                            class="bg-gray-400 dark:bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500 dark:hover:bg-gray-500">
                        {{ __('Cancelar') }}
                    </button>
                    <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        {{ __('Eliminar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id){ const m=document.getElementById('deleteModal'); const f=document.getElementById('deleteForm'); f.action=`/libros/${id}`; m.classList.remove('hidden'); }
        function closeModal(){ document.getElementById('deleteModal').classList.add('hidden'); }
    </script>
</body>
</html>
