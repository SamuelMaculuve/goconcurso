@extends('layouts.app')

@section('title', $company->name . ' — Perfil da Empresa')
@section('meta_description', Str::limit(strip_tags($company->description ?? 'Veja os concursos publicados por ' . $company->name . ' na plataforma GoConcurso.'), 155))

@section('content')

<div class="min-h-screen bg-gray-50">

    {{-- Cover / Hero --}}
    <div class="relative h-40 sm:h-56 bg-gradient-to-br from-forest-green to-[#1a3d2b] overflow-hidden">
        @if($company->cover_image)
            <img src="{{ Storage::url($company->cover_image) }}"
                 alt="" class="absolute inset-0 w-full h-full object-cover opacity-60">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Logo + Name card --}}
        <div class="relative -mt-12 sm:-mt-16 mb-6 flex items-end gap-5">
            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-white border-4 border-white shadow-lg overflow-hidden flex items-center justify-center flex-shrink-0">
                @if($company->logo)
                    <img src="{{ Storage::url($company->logo) }}"
                         alt="{{ $company->name }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-3xl font-extrabold text-gray-300">
                        {{ strtoupper(substr($company->name, 0, 2)) }}
                    </span>
                @endif
            </div>
            <div class="pb-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">{{ $company->name }}</h1>
                    @if($company->is_verified)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-forest-green/10 text-forest-green border border-forest-green/20">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Verificado
                        </span>
                    @endif
                </div>
                @if($company->sector)
                    <p class="text-sm text-gray-500 mt-0.5">{{ $company->sector }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-16">

            {{-- Left: About + Stats --}}
            <div class="lg:col-span-1 space-y-5">

                {{-- About --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-gray-800 mb-3">Sobre a empresa</h2>
                    @if($company->description)
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $company->description }}</p>
                    @else
                        <p class="text-sm text-gray-400 italic">Sem descrição disponível.</p>
                    @endif
                </div>

                {{-- Details --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Informações</h2>
                    <ul class="space-y-3 text-sm">

                        @if($company->country || $company->city)
                            <li class="flex items-start gap-2.5 text-gray-600">
                                <svg class="w-4 h-4 mt-0.5 text-terracota flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ collect([$company->city, $company->country])->filter()->implode(', ') }}
                            </li>
                        @endif

                        @if($company->website)
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 mt-0.5 text-terracota flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer"
                                   class="text-forest-green hover:underline truncate">
                                    {{ preg_replace('#^https?://#', '', $company->website) }}
                                </a>
                            </li>
                        @endif

                        @if($company->email)
                            <li class="flex items-start gap-2.5 text-gray-600">
                                <svg class="w-4 h-4 mt-0.5 text-terracota flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $company->email }}
                            </li>
                        @endif

                        @if($company->phone)
                            <li class="flex items-start gap-2.5 text-gray-600">
                                <svg class="w-4 h-4 mt-0.5 text-terracota flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $company->phone }}
                            </li>
                        @endif

                        @if($company->company_type)
                            <li class="flex items-start gap-2.5 text-gray-600">
                                <svg class="w-4 h-4 mt-0.5 text-terracota flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $company->company_type }}
                            </li>
                        @endif

                    </ul>
                </div>

                {{-- Stats --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Estatísticas</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-2xl font-extrabold text-terracota">{{ $company->contests()->count() }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Concursos</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-2xl font-extrabold text-forest-green">{{ $company->contests()->where('status', 'active')->count() }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Activos</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right: Active Contests --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-gray-800">Concursos Activos</h2>
                        @if($activeContests->isEmpty())
                            <span class="text-xs text-gray-400">Nenhum activo</span>
                        @endif
                    </div>

                    @if($activeContests->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($activeContests as $contest)
                                @php
                                    $deadline = $contest->deadline;
                                    $daysLeft = $deadline ? (int) floor(now()->diffInDays($deadline, false)) : null;
                                @endphp
                                <a href="{{ route('contests.show', $contest->slug) }}"
                                   class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:border-terracota/30 hover:bg-orange-50/30 transition group">
                                    <div class="flex-1 min-w-0">
                                        @if($contest->category)
                                            <span class="inline-block mb-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-forest-green/10 text-forest-green">
                                                {{ $contest->category->name }}
                                            </span>
                                        @endif
                                        <h3 class="text-sm font-semibold text-gray-900 group-hover:text-terracota transition line-clamp-1">
                                            {{ $contest->title }}
                                        </h3>
                                        @if($contest->city || $contest->country)
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ collect([$contest->city, $contest->country])->filter()->implode(', ') }}
                                            </p>
                                        @endif
                                    </div>
                                    @if($deadline && $daysLeft !== null)
                                        <span class="flex-shrink-0 text-xs font-semibold px-2.5 py-1 rounded-full
                                            {{ $daysLeft < 0 ? 'bg-gray-100 text-gray-400' : ($daysLeft <= 7 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-forest-green') }}">
                                            @if($daysLeft < 0)
                                                Expirado
                                            @elseif($daysLeft === 0)
                                                Hoje
                                            @elseif($daysLeft <= 30)
                                                {{ $daysLeft }} dias
                                            @else
                                                {{ $deadline->format('d/m/Y') }}
                                            @endif
                                        </span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm text-gray-400">Esta empresa não tem concursos activos de momento.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
