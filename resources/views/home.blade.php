@extends('layouts.app')

@section('title', 'GoConcurso — Procurement e Concursos em Moçambique')
@section('seo_description', 'Encontre concursos públicos e privados de fornecimento em Moçambique e África. GoConcurso conecta empresas compradoras a fornecedores de bens e serviços.')
@section('seo_url', route('home'))
@section('seo_type', 'website')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="relative overflow-hidden" style="background: #2D6A4F;">

    {{-- Decorative circles --}}
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-10 pointer-events-none"
         style="background: radial-gradient(circle, #D4A017, transparent); transform: translate(30%, -30%);"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full opacity-10 pointer-events-none"
         style="background: radial-gradient(circle, #F5E6C8, transparent); transform: translate(-30%, 30%);"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <span class="inline-block bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6 backdrop-blur-sm border border-white/30">
            🌍 A plataforma #1 de procurement em África
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            Concursos de Fornecimento<br>
            <span class="text-golden">e Prestação de Serviços</span>
        </h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto mb-10">
            Plataforma B2B de Concursos públicos e privados para aquisição de bens e contratação de serviços em toda a África.
            Publique Concurso ou apresente as suas propostas.
        </p>

        {{-- Search bar (Livewire) --}}
        <div class="max-w-2xl mx-auto">
            @livewire('contest-search-hero')
        </div>

        {{-- Quick filters --}}
        <div class="flex flex-wrap justify-center gap-2 mt-6">
            @foreach(['TI & Software', 'Construção', 'Consultoria', 'Manutenção', 'Segurança', 'Logística'] as $cat)
                <a href="{{ route('contests.index', ['search' => $cat]) }}"
                   class="bg-white/20 hover:bg-white/30 text-white text-xs px-3 py-1.5 rounded-full transition backdrop-blur-sm border border-white/20">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== STATS BANNER ===== --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-3 gap-6 text-center">
            <div>
                <p class="text-3xl font-extrabold text-terracota">{{ $stats['active_contests'] ?? '1.200+' }}</p>
                <p class="text-sm text-gray-500 mt-1 font-medium">Concurso Ativos</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-forest-green">{{ $stats['companies'] ?? '340+' }}</p>
                <p class="text-sm text-gray-500 mt-1 font-medium">Empresas Parceiras</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-golden">{{ $stats['candidates'] ?? '5.000+' }}</p>
                <p class="text-sm text-gray-500 mt-1 font-medium">Fornecedores Registados</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== FEATURED CONTESTS ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900">Concurso em Destaque</h2>
            <p class="text-sm text-gray-500 mt-1">Seleccionados especialmente para si</p>
        </div>
        <a href="{{ route('contests.index') }}"
           class="text-sm font-semibold text-terracota hover:text-orange-700 flex items-center gap-1 transition">
            Ver todos
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($contests as $contest)
            <x-contest-card :contest="$contest" />
        @empty
            <div class="col-span-3 text-center py-16 text-gray-400">
                <p class="text-sm">Nenhum concurso disponível de momento.</p>
            </div>
        @endforelse
    </div>
</section>

{{-- ===== CATEGORIES ===== --}}
<section class="bg-sand py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-extrabold text-gray-900">Explorar por Categoria</h2>
            <p class="text-sm text-gray-500 mt-2">Encontre Concurso de fornecimento na sua área de especialização</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $categories = [
                    ['name' => 'Tecnologia & TI',  'icon' => '💻', 'color' => 'bg-blue-100 text-blue-700'],
                    ['name' => 'Construção',        'icon' => '🏗️', 'color' => 'bg-amber-100 text-amber-700'],
                    ['name' => 'Consultoria',       'icon' => '🤝', 'color' => 'bg-yellow-100 text-yellow-700'],
                    ['name' => 'Manutenção',        'icon' => '🔧', 'color' => 'bg-orange-100 text-orange-700'],
                    ['name' => 'Segurança',         'icon' => '🛡️', 'color' => 'bg-gray-100 text-gray-700'],
                    ['name' => 'Saúde',             'icon' => '🏥', 'color' => 'bg-red-100 text-red-700'],
                    ['name' => 'Logística',         'icon' => '🚚', 'color' => 'bg-indigo-100 text-indigo-700'],
                    ['name' => 'Alimentação',       'icon' => '🍽️', 'color' => 'bg-green-100 text-green-700'],
                    ['name' => 'Energia',           'icon' => '⚡', 'color' => 'bg-lime-100 text-lime-700'],
                    ['name' => 'Limpeza',           'icon' => '🧹', 'color' => 'bg-purple-100 text-purple-700'],
                    ['name' => 'Telecomunicações',  'icon' => '📡', 'color' => 'bg-sky-100 text-sky-700'],
                    ['name' => 'Formação',          'icon' => '📚', 'color' => 'bg-pink-100 text-pink-700'],
                ];
            @endphp

            @foreach($categories as $cat)
                <a href="{{ route('contests.index', ['search' => $cat['name']]) }}"
                   class="group bg-white rounded-2xl p-4 text-center shadow-sm border border-gray-100
                          hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                    <div class="text-3xl mb-2">{{ $cat['icon'] }}</div>
                    <p class="text-xs font-semibold text-gray-800 group-hover:text-terracota transition">{{ $cat['name'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-2xl font-extrabold text-gray-900">Como Funciona</h2>
        <p class="text-sm text-gray-500 mt-2">Em apenas 3 passos simples</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @php
            $steps = [
                ['num' => '01', 'title' => 'Registe a sua Empresa',    'desc' => 'Crie a conta da sua empresa gratuitamente como Comprador, Fornecedor ou ambos. Aprovação rápida pelo administrador.', 'color' => 'bg-terracota'],
                ['num' => '02', 'title' => 'Explore Concurso',        'desc' => 'Pesquise Concurso de fornecimento por categoria, localização, orçamento e prazo. Guarde os mais relevantes.', 'color' => 'bg-golden'],
                ['num' => '03', 'title' => 'Submeta a sua Proposta',   'desc' => 'Apresente a sua proposta técnica e financeira directamente na plataforma. Acompanhe o estado em tempo real.', 'color' => 'bg-forest-green'],
            ];
        @endphp

        @foreach($steps as $step)
            <div class="relative text-center">
                {{-- Connector line --}}
                @if(!$loop->last)
                    <div class="hidden md:block absolute top-10 left-1/2 w-full h-px bg-gray-200 z-0"></div>
                @endif
                <div class="relative z-10">
                    <div class="w-20 h-20 {{ $step['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl font-extrabold text-white">{{ $step['num'] }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">{{ $step['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('register.company') }}"
           class="inline-flex items-center gap-2 bg-terracota text-white px-8 py-3 rounded-full font-semibold text-sm hover:bg-orange-700 transition shadow-md">
            Registar Empresa – É Grátis
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>

{{-- ===== CTA FOR COMPANIES ===== --}}
<section class="bg-forest-green py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6">Para Empresas Compradoras</span>
        <h2 class="text-3xl font-extrabold text-white mb-4">
            Publique Concurso e Encontre<br>os Melhores Fornecedores
        </h2>
        <p class="text-green-100 mb-8 max-w-xl mx-auto">
            Digitalize o seu processo de procurement. Receba propostas de fornecedores qualificados de toda a África.
            Planos flexíveis para empresas públicas e privadas.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register.company') }}"
               class="bg-golden text-gray-900 px-8 py-3 rounded-full font-semibold text-sm hover:bg-yellow-400 transition shadow-md">
                Registar Empresa Gratuitamente
            </a>
            <a href="{{ route('about') }}"
               class="bg-white/20 text-white border border-white/40 px-8 py-3 rounded-full font-semibold text-sm hover:bg-white/30 transition">
                Saber Mais
            </a>
        </div>
    </div>
</section>

@endsection
