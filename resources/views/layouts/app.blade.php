<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GoConcurso') — Procurement em Moçambique e África</title>
    @include('layouts.inc.seo')
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
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    {{-- ===== NAVIGATION ===== --}}
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-extrabold text-terracota tracking-tight">Go<span class="text-forest-green">Concurso</span></span>
                </a>

                {{-- Desktop nav links --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-terracota transition">Início</a>
                    <a href="{{ route('contests.index') }}" class="text-sm font-medium text-gray-700 hover:text-terracota transition">Concurso</a>
                    <a href="{{ route('companies') }}" class="text-sm font-medium text-gray-700 hover:text-terracota transition">Empresas</a>
                    <a href="{{ route('about') }}" class="text-sm font-medium text-gray-700 hover:text-terracota transition">Sobre</a>
                    <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-700 hover:text-terracota transition">Contacto</a>
                </div>

                {{-- Auth area --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 bg-sand text-terracota px-4 py-2 rounded-full text-sm font-semibold hover:bg-terracota hover:text-white transition focus:outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ Auth::user()->name }}
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-transition
                                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">

                                @if(Auth::user()->hasRole('super-admin'))
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="flex items-center gap-2 px-4 py-2 text-sm text-purple-700 font-semibold hover:bg-purple-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Administração
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                @endif

                                @if(Auth::user()->hasRole('company'))
                                    <a href="{{ route('company.dashboard') }}"
                                       class="flex items-center gap-2 px-4 py-2 text-sm text-forest-green font-semibold hover:bg-green-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        Dashboard Empresa
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                @endif

                                <a href="{{ route('profile.show') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Perfil
                                </a>
                                <a href="{{ route('profile.applications') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Candidaturas
                                </a>
                                <a href="{{ route('profile.saved') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                    Guardados
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Terminar Sessão
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-gray-700 hover:text-terracota transition">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-terracota text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-orange-700 transition shadow-sm">
                            Registar
                        </a>
                    @endauth
                </div>

                {{-- Mobile menu button --}}
                <button class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100" id="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div class="md:hidden hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-sand">Início</a>
                <a href="{{ route('contests.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-sand">Concurso</a>
                <a href="{{ route('companies') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-sand">Empresas</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-sand">Sobre</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-sand">Contacto</a>
                @guest
                    <div class="border-t border-gray-100 pt-2 mt-2 flex gap-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center py-2 border border-terracota text-terracota rounded-lg text-sm font-medium">Entrar</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center py-2 bg-terracota text-white rounded-lg text-sm font-medium">Registar</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <x-alert type="success" :message="session('success')" />
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <x-alert type="error" :message="session('error')" />
        </div>
    @endif

    {{-- ===== MAIN CONTENT ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Brand --}}
                <div class="col-span-1 md:col-span-1">
                    <span class="text-2xl font-extrabold text-terracota">Go<span class="text-sand">Concurso</span></span>
                    <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                        A plataforma líder de Concurso e oportunidades profissionais em África.
                    </p>
                    <div class="flex gap-3 mt-4">
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-terracota transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557a9.93 9.93 0 01-2.828.775 4.958 4.958 0 002.163-2.723 9.92 9.92 0 01-3.127 1.195 4.929 4.929 0 00-8.384 4.492A13.978 13.978 0 011.64 3.161a4.929 4.929 0 001.525 6.573A4.903 4.903 0 01.96 9.116v.061a4.928 4.928 0 003.95 4.827 4.936 4.936 0 01-2.224.084 4.93 4.93 0 004.6 3.42A9.876 9.876 0 010 19.54a13.94 13.94 0 007.548 2.212c9.056 0 14.01-7.503 14.01-14.01 0-.213-.005-.425-.014-.636A10.012 10.012 0 0024 4.557z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-terracota transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">Plataforma</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('contests.index') }}" class="hover:text-terracota transition">Concurso</a></li>
                        <li><a href="{{ route('companies') }}" class="hover:text-terracota transition">Empresas</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-terracota transition">Sobre Nós</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-terracota transition">Contacto</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">Para Empresas</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('register.company') }}" class="hover:text-terracota transition">Registar Empresa</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-terracota transition">Planos e Preços</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-terracota transition">Sobre Nós</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">Suporte</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('help') }}" class="hover:text-terracota transition">Centro de Ajuda</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-terracota transition">Fale Connosco</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-terracota transition">Política de Privacidade</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-terracota transition">Termos de Uso</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} GoConcurso. Todos os direitos reservados. Feito com para África.
            </div>
        </div>
    </footer>

    @livewireScripts

    <script>
        // Alpine.js for dropdowns
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', () => menu.classList.toggle('hidden'));
            }
        });
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>
</html>
