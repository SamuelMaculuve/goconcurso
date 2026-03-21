@extends('layouts.company')

@section('title', 'Estatísticas')
@section('page-title', 'Estatísticas')
@section('page-subtitle', 'Desempenho dos seus Concurso')

@section('content')

{{-- Summary cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['label' => 'Concurso',     'value' => $totalContests,     'color' => 'text-forest-green',  'bg' => 'bg-green-50'],
        ['label' => 'Visualizações', 'value' => $totalViews,        'color' => 'text-terracota',      'bg' => 'bg-orange-50'],
        ['label' => 'Interessados',  'value' => $totalInterests,    'color' => 'text-golden',          'bg' => 'bg-yellow-50'],
        ['label' => 'Candidaturas',  'value' => $totalApplications, 'color' => 'text-indigo-600',      'bg' => 'bg-indigo-50'],
    ] as $card)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-medium text-gray-500 mb-1">{{ $card['label'] }}</p>
            <p class="text-3xl font-bold {{ $card['color'] }}">{{ number_format($card['value']) }}</p>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Contests by status --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Concurso por Estado</h2>
        @php
            $statusLabels = [
                'pending'  => ['label' => 'Pendente',   'color' => 'bg-yellow-400'],
                'approved' => ['label' => 'Aprovado',   'color' => 'bg-forest-green'],
                'rejected' => ['label' => 'Rejeitado',  'color' => 'bg-red-400'],
                'closed'   => ['label' => 'Encerrado',  'color' => 'bg-gray-400'],
            ];
            $contestTotal = max($contestsByStatus->sum(), 1);
        @endphp
        @forelse($contestsByStatus as $status => $count)
            @php $meta = $statusLabels[$status] ?? ['label' => ucfirst($status), 'color' => 'bg-gray-400']; @endphp
            <div class="mb-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs text-gray-600">{{ $meta['label'] }}</span>
                    <span class="text-xs font-semibold text-gray-800">{{ $count }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="{{ $meta['color'] }} h-2 rounded-full transition-all"
                         style="width: {{ round($count / $contestTotal * 100) }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400 text-center py-6">Sem Concurso ainda</p>
        @endforelse
    </div>

    {{-- Applications by status --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Candidaturas por Estado</h2>
        @php
            $appStatusLabels = [
                'pending'   => ['label' => 'Pendente',     'color' => 'bg-yellow-400'],
                'reviewing' => ['label' => 'Em Análise',   'color' => 'bg-blue-400'],
                'accepted'  => ['label' => 'Seleccionada', 'color' => 'bg-forest-green'],
                'rejected'  => ['label' => 'Rejeitada',    'color' => 'bg-red-400'],
            ];
            $appTotal = max($applicationsByStatus->sum(), 1);
        @endphp
        @forelse($applicationsByStatus as $status => $count)
            @php $meta = $appStatusLabels[$status] ?? ['label' => ucfirst($status), 'color' => 'bg-gray-400']; @endphp
            <div class="mb-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs text-gray-600">{{ $meta['label'] }}</span>
                    <span class="text-xs font-semibold text-gray-800">{{ $count }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="{{ $meta['color'] }} h-2 rounded-full transition-all"
                         style="width: {{ round($count / $appTotal * 100) }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400 text-center py-6">Sem candidaturas ainda</p>
        @endforelse
    </div>

</div>

{{-- Top contests table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-sm font-semibold text-gray-700">Concurso por Desempenho</h2>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Concurso</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Visualizações</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Interessados</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidaturas</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($topContests as $contest)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <a href="{{ route('contests.show', $contest->slug) }}"
                           class="font-medium text-gray-800 hover:text-forest-green transition line-clamp-1">
                            {{ $contest->title }}
                        </a>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $contest->deadline ? 'Prazo: '.\Carbon\Carbon::parse($contest->deadline)->format('d/m/Y') : '–' }}
                        </p>
                    </td>
                    <td class="px-5 py-4 text-center text-gray-700 font-medium">{{ number_format($contest->views_count ?? 0) }}</td>
                    <td class="px-5 py-4 text-center text-gray-700 font-medium">{{ $contest->interests_count }}</td>
                    <td class="px-5 py-4 text-center text-gray-700 font-medium">{{ $contest->applications_count }}</td>
                    <td class="px-5 py-4 text-center">
                        <x-badge :type="$contest->status" :label="ucfirst($contest->status)" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <p class="text-sm text-gray-400">Nenhum concurso publicado ainda</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
