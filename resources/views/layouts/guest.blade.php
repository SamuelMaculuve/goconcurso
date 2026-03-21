<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Autenticação') – Concurso</title>

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
<body class="min-h-screen font-sans antialiased" style="background-color:#F5E6C8;">

    {{-- Background pattern overlay --}}
    <div class="fixed inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle at 25px 25px, rgba(192,96,42,0.08) 2px, transparent 0),
                                  radial-gradient(circle at 75px 75px, rgba(45,106,79,0.06) 2px, transparent 0);
                background-size: 100px 100px;">
    </div>

    {{-- Decorative blobs --}}
    <div class="fixed top-0 left-0 w-96 h-96 rounded-full opacity-20 pointer-events-none"
         style="background: radial-gradient(circle, #C0602A, transparent); transform: translate(-50%, -50%);"></div>
    <div class="fixed bottom-0 right-0 w-96 h-96 rounded-full opacity-20 pointer-events-none"
         style="background: radial-gradient(circle, #2D6A4F, transparent); transform: translate(50%, 50%);"></div>

    <div class="relative min-h-screen flex flex-col items-center justify-center px-4 py-12">

        {{-- Logo --}}
        <div class="mb-8 text-center">
            <a href="{{ route('home') }}" class="inline-block">
                <span class="text-3xl font-extrabold text-terracota tracking-tight">
                    Go<span class="text-forest-green">Concurso</span>
                </span>
            </a>
            <p class="mt-2 text-sm text-gray-600 font-medium">Oportunidades em toda a África</p>
        </div>

        {{-- Card --}}
        <div class="w-full @yield('card_width', 'max-w-md') bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

            {{-- Card header stripe --}}
            <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #C0602A, #D4A017, #2D6A4F);"></div>

            <div class="p-8">
                {{-- Flash messages --}}
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif
                @if(session('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif

                @yield('content')
            </div>
        </div>

        {{-- Footer link --}}
        <p class="mt-8 text-xs text-gray-500">
            &copy; {{ date('Y') }} GoConcurso &mdash;
            <a href="{{ route('about') }}" class="hover:text-terracota underline">Sobre</a> &middot;
            <a href="{{ route('contact') }}" class="hover:text-terracota underline">Contacto</a> &middot;
            <a href="{{ route('privacy') }}" class="hover:text-terracota underline">Privacidade</a> &middot;
            <a href="{{ route('terms') }}" class="hover:text-terracota underline">Termos</a>
        </p>
    </div>

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
