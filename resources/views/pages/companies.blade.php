@extends('layouts.app')

@section('title', 'Empresas em Moçambique — GoConcurso')
@section('seo_description', 'Explore as empresas verificadas que publicam concursos de fornecimento em Moçambique e África no GoConcurso. Encontre oportunidades de negócio.')
@section('seo_url', route('companies'))
@section('seo_type', 'website')

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-[#2D6A4F] to-[#1a4030] text-white py-14">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold mb-2">Empresas Parceiras</h1>
        <p class="text-green-100">Conheça as organizações que publicam oportunidades no Concurso</p>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 py-12">
    @if($companies->isEmpty())
        <div class="text-center py-20">
            <span class="text-5xl">🏢</span>
            <p class="mt-4 text-gray-500">Nenhuma empresa registada ainda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($companies as $company)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow">
                {{-- Logo / Initials --}}
                <div class="w-16 h-16 rounded-xl flex items-center justify-center text-2xl font-bold text-white mb-4 overflow-hidden"
                     style="background-color: #C0602A">
                    @if($company->logo)
                        <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($company->name, 0, 2)) }}
                    @endif
                </div>

                <h3 class="font-bold text-gray-800 mb-1">{{ $company->name }}</h3>
                <p class="text-gray-500 text-xs mb-2">{{ $company->sector ?? ucfirst($company->company_type) }}</p>
                <p class="text-gray-400 text-xs">📍 {{ $company->city }}, {{ $company->country }}</p>

                @if($company->contests_count > 0)
                    <span class="mt-3 bg-[#2D6A4F] text-white text-xs px-3 py-1 rounded-full">
                        {{ $company->contests_count }} concurso(s) activo(s)
                    </span>
                @endif

                @if($company->is_verified)
                    <span class="mt-2 text-[#D4A017] text-xs font-medium">✅ Verificada</span>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $companies->links() }}</div>
    @endif
</div>
@endsection
