@extends('layouts.app')

@section('title', $contest->title)
@section('seo_description', \Illuminate\Support\Str::limit(strip_tags($contest->description ?? ''), 155) ?: 'Concurso de fornecimento publicado em GoConcurso — a plataforma de procurement em Moçambique.')
@section('seo_url', route('contests.show', $contest->slug))
@section('seo_type', 'article')
@section('seo_image', $contest->company->logo ? asset('storage/' . $contest->company->logo) : null)
@section('seo_published', $contest->created_at->toIso8601String())
@section('seo_modified',  $contest->updated_at->toIso8601String())

@section('seo_breadcrumbs')
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        { "@@type": "ListItem", "position": 1, "name": "Início",    "item": "{{ route('home') }}" },
        { "@@type": "ListItem", "position": 2, "name": "Concursos", "item": "{{ route('contests.index') }}" },
        { "@@type": "ListItem", "position": 3, "name": "{{ addslashes($contest->title) }}", "item": "{{ route('contests.show', $contest->slug) }}" }
    ]
}
@endsection

@section('seo_schema')
{
    "@@context": "https://schema.org",
    "@@type": "GovernmentService",
    "name": "{{ addslashes($contest->title) }}",
    "description": "{{ \Illuminate\Support\Str::limit(strip_tags(addslashes($contest->description ?? '')), 200) }}",
    "url": "{{ route('contests.show', $contest->slug) }}",
    "serviceType": "Concurso de Fornecimento",
    "areaServed": {
        "@@type": "Country",
        "name": "{{ $contest->company->country ?? 'Moçambique' }}"
    },
    "provider": {
        "@@type": "Organization",
        "name": "{{ addslashes($contest->company->name ?? 'GoConcurso') }}",
        "url": "{{ config('app.url') }}"
    },
    "offers": {
        "@@type": "Offer",
        "availability": "https://schema.org/InStock",
        "validThrough": "{{ $contest->deadline ? $contest->deadline->toIso8601String() : '' }}",
        "url": "{{ route('contests.show', $contest->slug) }}"
    },
    "datePosted": "{{ $contest->created_at->toIso8601String() }}"
}
@endsection

@section('content')

{{-- Breadcrumb + header --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-gray-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-terracota transition">Início</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('contests.index') }}" class="hover:text-terracota transition">Concurso</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 font-medium truncate max-w-xs">{{ $contest->title }}</span>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row gap-4 items-start">

            {{-- Company logo --}}
            <div class="w-16 h-16 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden border border-gray-200 flex items-center justify-center">
                @if($contest->company->logo ?? false)
                    <img src="{{ Storage::url($contest->company->logo) }}"
                         alt="{{ $contest->company->name }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-xl font-bold text-gray-400">
                        {{ strtoupper(substr($contest->company->name ?? 'C', 0, 2)) }}
                    </span>
                @endif
            </div>

            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <x-badge :type="$contest->category->slug ?? 'default'" :label="$contest->category->name ?? 'Geral'" />

                    @if($contest->is_featured ?? false)
                        <span class="bg-golden text-gray-900 text-xs font-bold px-2 py-0.5 rounded-full">Destaque</span>
                    @endif

                    <x-badge :type="$contest->status ?? 'active'" :label="$contest->status_label ?? 'Aberto'" />
                </div>

                <h1 class="text-2xl font-extrabold text-gray-900 mb-1">{{ $contest->title }}</h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <a href="#" class="font-semibold text-forest-green hover:underline">
                        {{ $contest->company->name ?? 'Empresa' }}
                    </a>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $contest->location ?? 'Remoto' }}
                    </span>
                    @if($contest->deadline)
                        <span class="flex items-center gap-1 text-terracota font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Prazo: {{ \Carbon\Carbon::parse($contest->deadline)->format('d/m/Y') }}
                            ({{ \Carbon\Carbon::parse($contest->deadline)->diffForHumans() }})
                        </span>
                    @endif
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $contest->views_count ?? 0 }} visualizações
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== TWO-COLUMN LAYOUT ===== --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ===== LEFT COLUMN – MAIN CONTENT ===== --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Description --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-5 bg-terracota rounded-full inline-block"></span>
                    Descrição do Concurso
                </h2>
                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($contest->description ?? '')) !!}
                </div>
            </div>

            {{-- Requirements --}}
            @if($contest->requirements ?? false)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-5 bg-golden rounded-full inline-block"></span>
                    Requisitos
                </h2>
                <div class="prose prose-sm max-w-none text-gray-600">
                    {!! nl2br(e($contest->requirements)) !!}
                </div>
            </div>
            @endif

            {{-- Criteria / Benefits --}}
            @if($contest->benefits ?? false)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-5 bg-forest-green rounded-full inline-block"></span>
                    Critérios de Avaliação
                </h2>
                <div class="prose prose-sm max-w-none text-gray-600">
                    {!! nl2br(e($contest->benefits)) !!}
                </div>
            </div>
            @endif

        </div>

        {{-- ===== RIGHT COLUMN – SIDEBAR ===== --}}
        <div class="space-y-6">

            {{-- Action card based on participation_type --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Participar</h3>

                @switch($contest->participation_type ?? 'info_only')

                    @case('info_only')
                        <p class="text-sm text-gray-500 mb-4">
                            Este concurso é gerido externamente. Clique para aceder ao site oficial.
                        </p>
                        <a href="{{ $contest->external_url ?? '#' }}" target="_blank" rel="noopener"
                           class="block w-full text-center bg-terracota text-white px-4 py-3 rounded-xl font-semibold text-sm hover:bg-orange-700 transition">
                            Aceder ao Concurso
                            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @break

                    @case('interest_submission')
                        @if($contest->accepts_proposals)
                            @livewire('interest-form', ['contest' => $contest])
                        @else
                            <div class="text-center py-6">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">Submissões encerradas</p>
                                <p class="text-xs text-gray-400 mt-1">Este concurso não está a aceitar submissões de interesse.</p>
                            </div>
                        @endif
                    @break

                    @case('full_application')
                        @if($contest->accepts_proposals)
                            @auth
                                @livewire('application-form', ['contest' => $contest])
                            @else
                                @livewire('interest-form', ['contest' => $contest])
                            @endauth
                        @else
                            <div class="text-center py-6">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 715.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">Submissão de propostas encerrada</p>
                                <p class="text-xs text-gray-400 mt-1">A empresa não está a aceitar propostas pela plataforma neste momento.</p>
                            </div>
                        @endif
                    @break

                @endswitch

                {{-- Save button --}}
                <div class="mt-3 border-t border-gray-100 pt-3">
                    @livewire('save-contest', ['contestId' => $contest->id])
                </div>
            </div>

            {{-- Company info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Sobre a Empresa</h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center border border-gray-200 overflow-hidden">
                        @if($contest->company->logo ?? false)
                            <img src="{{ Storage::url($contest->company->logo) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-bold text-gray-400">
                                {{ strtoupper(substr($contest->company->name ?? 'C', 0, 2)) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $contest->company->name ?? 'Empresa' }}</p>
                        <p class="text-xs text-gray-500">{{ $contest->company->sector ?? '' }}</p>
                    </div>
                </div>
                @if($contest->company->description ?? false)
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">{{ $contest->company->description }}</p>
                @endif
                <a href="{{ route('companies.show', $contest->company->slug) }}"
                   class="block mt-3 text-xs text-forest-green font-semibold hover:underline">
                    Ver perfil da empresa &rarr;
                </a>
            </div>

            {{-- Details list --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4">Detalhes do concurso</h3>
                <ul class="space-y-3 text-xs">
                    @if($contest->type ?? false)
                    <li class="flex items-center justify-between gap-2">
                        <span class="text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Tipo
                        </span>
                        <span class="font-semibold text-gray-700">{{ $contest->type }}</span>
                    </li>
                    @endif
                    @if($contest->location ?? false)
                    <li class="flex items-center justify-between gap-2">
                        <span class="text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Localizacao
                        </span>
                        <span class="font-semibold text-gray-700">{{ $contest->location }}</span>
                    </li>
                    @endif
                    @if(($contest->budget_min ?? false) || ($contest->budget_max ?? false))
                    <li class="flex items-center justify-between gap-2">
                        <span class="text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Orçamento
                        </span>
                        <span class="font-semibold text-gray-700">
                            @php $cur = $contest->budget_currency ?? 'USD'; @endphp
                            @if($contest->budget_min && $contest->budget_max)
                                {{ $cur }} {{ number_format($contest->budget_min) }} — {{ number_format($contest->budget_max) }}
                            @elseif($contest->budget_min)
                                A partir de {{ $cur }} {{ number_format($contest->budget_min) }}
                            @elseif($contest->budget_max)
                                Até {{ $cur }} {{ number_format($contest->budget_max) }}
                            @endif
                        </span>
                    </li>
                    @endif
                    @if($contest->deadline ?? false)
                    <li class="flex items-center justify-between gap-2">
                        <span class="text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Prazo limite
                        </span>
                        <span class="font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($contest->deadline)->format('d/m/Y') }}
                        </span>
                    </li>
                    @endif
                    <li class="flex items-center justify-between gap-2">
                        <span class="text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Visualizacoes
                        </span>
                        <span class="font-semibold text-gray-700">{{ $contest->views_count ?? 0 }}</span>
                    </li>
                    <li class="flex items-center justify-between gap-2">
                        <span class="text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Publicado em
                        </span>
                        <span class="font-semibold text-gray-700">
                            {{ isset($contest->created_at) ? \Carbon\Carbon::parse($contest->created_at)->format('d/m/Y') : '—' }}
                        </span>
                    </li>
                </ul>
            </div>

            {{-- Stats --}}
            <div class="bg-[#F5E6C8] rounded-2xl border border-yellow-200 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Estatisticas</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Propostas</span>
                        <span class="font-semibold text-gray-800">{{ $contest->applications_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Interessados</span>
                        <span class="font-semibold text-gray-800">{{ $contest->interests_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Guardado por</span>
                        <span class="font-semibold text-gray-800">{{ $contest->saves_count ?? 0 }} pessoas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related contests --}}
    @if(isset($relatedContests) && $relatedContests->count())
    <div class="mt-12">
        <h2 class="text-xl font-extrabold text-gray-900 mb-6">Concurso Relacionados</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedContests as $related)
                <x-contest-card :contest="$related" />
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
