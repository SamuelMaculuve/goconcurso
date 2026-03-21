@extends('layouts.app')

@section('title', 'Sobre o GoConcurso — Plataforma de Procurement em Moçambique')
@section('seo_description', 'Conheça o GoConcurso: a plataforma digital líder de procurement que conecta empresas compradoras a fornecedores de bens e serviços em Moçambique e em toda África.')
@section('seo_url', route('about'))
@section('seo_type', 'website')

@section('content')
{{-- Hero --}}
<section class="bg-gradient-to-br from-[#C0602A] to-[#8B3A15] text-white py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Sobre o Concurso</h1>
        <p class="text-xl text-orange-100">A plataforma que conecta talentos a oportunidades em África</p>
    </div>
</section>

{{-- Mission --}}
<section class="max-w-4xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">A Nossa Missão</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                O GoConcurso nasceu com o propósito de democratizar o acesso a oportunidades profissionais e académicas em África.
                Centralizamos Concursos públicos, licitações e muito mais numa única plataforma moderna e acessível.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Acreditamos que o talento africano merece uma plataforma à altura — intuitiva, transparente e eficiente,
                que elimine as barreiras entre quem procura e quem oferece oportunidades.
            </p>
        </div>
        <div class="bg-[#F5E6C8] rounded-2xl p-8 text-center">
            <div class="text-5xl mb-4">🌍</div>
            <h3 class="text-xl font-bold text-[#C0602A] mb-2">Feito para África</h3>
            <p class="text-gray-600 text-sm">Desenvolvido com foco nas necessidades e realidades do mercado africano</p>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="bg-gray-50 py-16">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">Os Nossos Valores</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['🎯', 'Transparência', 'Todas as oportunidades são publicadas de forma clara e completa, sem informações escondidas.'],
                ['🤝', 'Inclusão', 'Trabalhamos para que todos, independente da sua localização, possam aceder às melhores oportunidades.'],
                ['⚡', 'Inovação', 'Melhoramos continuamente a plataforma para oferecer a melhor experiência possível.'],
            ] as [$icon, $title, $desc])
            <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                <div class="text-4xl mb-3">{{ $icon }}</div>
                <h3 class="font-bold text-gray-800 mb-2">{{ $title }}</h3>
                <p class="text-gray-600 text-sm">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team section placeholder --}}
<section class="max-w-5xl mx-auto px-4 py-16">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-3">A Nossa Equipa</h2>
    <p class="text-gray-500 text-center mb-10 max-w-xl mx-auto">
        Somos uma equipa apaixonada por tecnologia e pelo desenvolvimento de Africa,
        comprometida em construir a melhor plataforma de oportunidades do continente.
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach([
            ['Fundador & CEO', 'Lider visionario com experiencia em tecnologia e mercados africanos.'],
            ['CTO', 'Responsavel pela arquitectura tecnica e inovacao da plataforma.'],
            ['Head of Growth', 'Especialista em expansao de mercados e parcerias estrategicas em Africa.'],
        ] as $index => [$role, $bio])
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-[#F5E6C8] flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="h-4 bg-gray-200 rounded w-24 mx-auto mb-2 animate-pulse"></div>
            <p class="text-xs font-semibold text-[#C0602A] mb-3">{{ $role }}</p>
            <p class="text-xs text-gray-500 leading-relaxed">{{ $bio }}</p>
        </div>
        @endforeach
    </div>
    <p class="text-center text-sm text-gray-400 mt-8 italic">
        Perfis da equipa em breve disponíveis.
    </p>
</section>

{{-- Stats --}}
<section class="bg-[#2D6A4F] py-14">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
            @foreach([
                ['5+', 'Paises cobertos'],
                ['1000+', 'Concurso publicados'],
                ['10 000+', 'Utilizadores registados'],
                ['500+', 'Empresas parceiras'],
            ] as [$number, $label])
            <div>
                <div class="text-3xl font-extrabold mb-1">{{ $number }}</div>
                <div class="text-sm text-green-200">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="max-w-3xl mx-auto px-4 py-16 text-center">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Pronto para começar?</h2>
    <p class="text-gray-600 mb-8">Junte-se a milhares de profissionais que já utilizam o Concurso.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register') }}" class="bg-[#C0602A] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#a0501f] transition-colors">
            Criar Conta Gratuitamente
        </a>
        <a href="{{ route('contests.index') }}" class="border-2 border-[#C0602A] text-[#C0602A] px-8 py-3 rounded-lg font-semibold hover:bg-[#C0602A] hover:text-white transition-colors">
            Ver Concurso
        </a>
    </div>
</section>
@endsection
