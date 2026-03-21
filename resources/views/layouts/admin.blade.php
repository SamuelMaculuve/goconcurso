<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') – Concurso</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        terracota: '#C0602A',
                        golden:    '#D4A017',
                        'forest-green': '#2D6A4F',
                        sand:      '#F5E6C8',
                        'sidebar-bg': '#1a1a2e',
                        'sidebar-hover': '#16213e',
                    }
                }
            }
        }
    </script>

    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 flex-shrink-0 flex flex-col" style="background-color:#1a1a2e;">

        {{-- Logo --}}
        <div class="flex items-center gap-2 px-6 py-5 border-b border-white/10">
            <a href="{{ route('home') }}" class="text-xl font-extrabold text-terracota tracking-tight">
                Go<span class="text-sand">Concurso</span>
            </a>
            <span class="ml-auto text-xs bg-purple-600 text-white px-2 py-0.5 rounded-full font-semibold">Admin</span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            @php
                $adminLinks = [
                    ['route' => 'admin.dashboard',       'label' => 'Dashboard',     'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'admin.users.index',     'label' => 'Utilizadores',  'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['route' => 'admin.companies.index', 'label' => 'Empresas',      'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['route' => 'admin.contests.index',  'label' => 'Concurso',     'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['route' => 'admin.categories.index','label' => 'Categorias',    'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z'],
                    ['route' => 'admin.plans.index',     'label' => 'Planos',        'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                ];
            @endphp

            @foreach($adminLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'.*')
                             ? 'bg-terracota text-white'
                             : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
                    </svg>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- User & Logout --}}
        <div class="border-t border-white/10 px-4 py-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-terracota flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-400 truncate">Super Admin</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-400 hover:text-red-400 hover:bg-white/5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Terminar Sessão
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN AREA ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-gray-500 mt-0.5">@yield('page-subtitle', 'Painel de Administração')</p>
            </div>
            <div class="flex items-center gap-4">
                {{-- Notifications --}}
                <button class="relative p-2 text-gray-500 hover:text-terracota hover:bg-sand rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-terracota rounded-full"></span>
                </button>

                <div class="flex items-center gap-2 text-sm">
                    <div class="w-8 h-8 rounded-full bg-terracota flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mx-6 mt-4">
                <x-alert type="success" :message="session('success')" />
            </div>
        @endif
        @if(session('error'))
            <div class="mx-6 mt-4">
                <x-alert type="error" :message="session('error')" />
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

@livewireScripts
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stack('scripts')
</body>
</html>
