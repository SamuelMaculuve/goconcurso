@extends('layouts.app')

@section('title', 'Concursos de Fornecimento em Moçambique')
@section('seo_description', 'Pesquise e candidate-se a concursos públicos e privados de fornecimento de bens e serviços em Moçambique e África. Actualizados diariamente.')
@section('seo_url', route('contests.index'))
@section('seo_type', 'website')

@section('content')

{{-- Page header --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex items-center gap-2 text-xs text-gray-400 mb-3">
            <a href="{{ route('home') }}" class="hover:text-terracota transition">Início</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 font-medium">Concurso</span>
        </nav>
        <h1 class="text-2xl font-extrabold text-gray-900">Todos os Concurso</h1>
        <p class="text-sm text-gray-500 mt-1">
            Explore as melhores oportunidades disponíveis em toda a África
        </p>
    </div>
</div>

{{-- Main content --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('contest-search')
</div>

@endsection
