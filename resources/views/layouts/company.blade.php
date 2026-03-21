<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Empresa') – Concurso</title>

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
                    }
                }
            }
        }
    </script>

    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 flex-shrink-0 flex flex-col bg-forest-green">

        {{-- Logo --}}
        <div class="flex items-center gap-2 px-6 py-5 border-b border-white/20">
            <a href="{{ route('home') }}" class="text-xl font-extrabold text-sand tracking-tight">
                Go<span class="text-golden">Concurso</span>
            </a>
            <span class="ml-auto text-xs bg-golden text-gray-900 px-2 py-0.5 rounded-full font-semibold">Empresa</span>
        </div>

        {{-- Company name --}}
        @auth
            @if(Auth::user()->company)
            <div class="px-6 py-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    @if(Auth::user()->company->logo)
                        <img src="{{ Storage::url(Auth::user()->company->logo) }}"
                             alt="{{ Auth::user()->company->name }}"
                             class="w-10 h-10 rounded-lg object-cover border-2 border-white/20">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->company->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->company->name }}</p>
                        <p class="text-xs text-green-200 truncate">
                            {{ Auth::user()->company->plan->name ?? 'Plano Gratuito' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
        @endauth

        {{-- Nav --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            @php
                $companyLinks = [
                    ['route' => 'company.dashboard',             'label' => 'Dashboard',          'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'company.contests.index',        'label' => 'Meus Concurso',     'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['route' => 'company.contests.create',       'label' => 'Publicar Concurso',  'icon' => 'M12 4v16m8-8H4'],
                    ['route' => 'company.interests.index',       'label' => 'Interessados',       'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                    ['route' => 'company.applications.index',    'label' => 'Candidaturas',       'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['route' => 'company.statistics',            'label' => 'Estatísticas',       'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ];
            @endphp

            @foreach($companyLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs($link['route']) || request()->routeIs($link['route'].'.*')
                             ? 'bg-white/20 text-white font-semibold'
                             : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
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
                <div class="w-8 h-8 rounded-full bg-golden flex items-center justify-center text-gray-900 text-xs font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'E', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Empresa' }}</p>
                    <p class="text-xs text-green-200 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 w-full px-3 py-2 text-sm text-green-200 hover:text-red-300 hover:bg-white/5 rounded-lg transition">
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
                <p class="text-xs text-gray-500 mt-0.5">
                    @auth
                        {{ Auth::user()->company->name ?? 'Painel da Empresa' }}
                    @endauth
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('company.contests.create') }}"
                   class="flex items-center gap-2 bg-forest-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Novo Concurso
                </a>
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-8 h-8 rounded-full bg-forest-green flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'E', 0, 1)) }}
                    </div>
                    <span class="font-medium text-gray-700">{{ Auth::user()->name ?? 'Empresa' }}</span>
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
