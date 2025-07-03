<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Painel de Produtividade') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Prism.js para syntax highlighting -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
        
        <!-- SortableJS para drag & drop -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        
        <!-- TinyMCE para editor de texto rico -->
        <script src="https://cdn.tiny.cloud/1/5rdc37kuv4zeu692hpqayi5wtve055j69ybxpza994pzg26j/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <!-- Navbar Topo -->
            <nav class="bg-white shadow-sm border-b w-full z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <!-- Links principais -->
                        <div class="flex space-x-4">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('projects.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Projetos
                            </a>
                            <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('tasks.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Minhas Tarefas
                            </a>
                            <a href="{{ route('notes.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('notes.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Anotações
                            </a>
                            <a href="{{ route('snippets.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('snippets.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                                Snippets
                            </a>
                        </div>
                        <!-- Menu do usuário -->
                        <div class="relative group">
                            <button class="flex items-center focus:outline-none" id="user-menu-button">
                                <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="ml-2 text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Dropdown -->
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border z-50">
                                <div class="px-4 py-3 border-b">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Conteúdo principal -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
