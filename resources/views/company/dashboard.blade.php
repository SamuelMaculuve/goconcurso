@extends('layouts.company')

@section('title', 'Dashboard Empresa')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
        $statCards = [
            ['label' => 'Concursos Activos',  'value' => $stats['active_contests'] ?? 0,    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'bg-forest-green', 'text' => 'text-forest-green', 'bg' => 'bg-green-50'],
            ['label' => 'Total Candidaturas', 'value' => $stats['total_applications'] ?? 0,  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'bg-terracota', 'text' => 'text-terracota', 'bg' => 'bg-orange-50'],
            ['label' => 'Interessados',        'value' => $stats['total_interests'] ?? 0,    'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'color' => 'bg-golden', 'text' => 'text-yellow-700', 'bg' => 'bg-yellow-50'],
            ['label' => 'Concursos Expirados','value' => $stats['expired_contests'] ?? 0,   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'bg-gray-500', 'text' => 'text-gray-600', 'bg' => 'bg-gray-50'],
        ];
    @endphp

    @foreach($statCards as $card)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4">
            <div class="w-11 h-11 {{ $card['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 {{ $card['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900">{{ $card['value'] }}</p>
                <p class="text-xs text-gray-500 font-medium mt-0.5">{{ $card['label'] }}</p>
            </div>
        </div>
    @endforeach
</div>

{{-- Two columns --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Recent contests --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-gray-900">Concursos Recentes</h2>
            <a href="{{ route('company.contests.index') }}" class="text-xs text-forest-green font-semibold hover:underline">Ver todos &rarr;</a>
        </div>

        @forelse($recentContests ?? [] as $contest)
            <div class="flex items-center gap-3 py-3 border-b border-gray-50 last:border-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $contest->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ isset($contest->deadline) ? 'Prazo: '.\Carbon\Carbon::parse($contest->deadline)->format('d/m/Y') : 'Sem prazo' }}
                    </p>
                </div>
                <x-badge :type="$contest->status ?? 'draft'" :label="$contest->status_label ?? 'Rascunho'" />
            </div>
        @empty
            <div class="py-8 text-center">
                <p class="text-sm text-gray-400 mb-3">Ainda não publicou nenhum concurso</p>
                <a href="{{ route('company.contests.create') }}"
                   class="inline-flex items-center gap-2 bg-forest-green text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-green-800 transition">
                    Publicar Primeiro Concurso
                </a>
            </div>
        @endforelse
    </div>

    {{-- Recent applications --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-gray-900">Candidaturas Recentes</h2>
            <a href="{{ route('company.applications.index') }}" class="text-xs text-forest-green font-semibold hover:underline">Ver todas &rarr;</a>
        </div>

        @forelse($recentApplications ?? [] as $application)
            <div class="flex items-center gap-3 py-3 border-b border-gray-50 last:border-0">
                <div class="w-8 h-8 rounded-full bg-sand flex items-center justify-center flex-shrink-0">
                    <span class="text-xs font-bold text-terracota">
                        {{ strtoupper(substr($application->user->name ?? 'U', 0, 2)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $application->user->name ?? 'Candidato' }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $application->contest->title ?? '' }}</p>
                </div>
                <x-badge :type="$application->status ?? 'pending'" :label="$application->status_label ?? 'Pendente'" />
            </div>
        @empty
            <div class="py-8 text-center">
                <p class="text-sm text-gray-400">Nenhuma candidatura recebida ainda</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Quick action bar --}}
<div class="mt-6 bg-forest-green rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
    <div>
        <p class="text-white font-bold text-base">Pronto para publicar um novo concurso?</p>
        <p class="text-green-200 text-sm mt-0.5">Alcance milhares de candidatos qualificados em toda a África.</p>
    </div>
    <a href="{{ route('company.contests.create') }}"
       class="flex-shrink-0 bg-golden text-gray-900 px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-yellow-400 transition shadow">
        Publicar Concurso
    </a>
</div>

@endsection
