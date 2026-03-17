@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Administrativo')
@section('page-subtitle', 'Visão geral da plataforma')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- Total Utilizadores --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-terracota/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-terracota" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['users'] ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Total Utilizadores</p>
        </div>
    </div>

    {{-- Total Empresas --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-golden/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-golden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['companies'] ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Total Empresas</p>
        </div>
    </div>

    {{-- Total Concursos --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-forest-green/10 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-forest-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['contests'] ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Total Concursos</p>
        </div>
    </div>

    {{-- Candidaturas Hoje --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-800">{{ number_format($stats['applications_today'] ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Candidaturas Hoje</p>
        </div>
    </div>

</div>

{{-- Chart + Recent Contests --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Chart --}}
    <div class="xl:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-semibold text-gray-700 mb-4">Crescimento de Utilizadores</h2>
        <div class="relative h-64">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>

    {{-- Quick stats --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col gap-4">
        <h2 class="text-base font-semibold text-gray-700">Resumo Rápido</h2>
        <div class="flex items-center justify-between py-3 border-b border-gray-50">
            <span class="text-sm text-gray-500">Concursos Pendentes</span>
            <span class="text-sm font-semibold text-golden bg-golden/10 px-2.5 py-0.5 rounded-full">{{ $stats['pending_contests'] ?? 0 }}</span>
        </div>
        <div class="flex items-center justify-between py-3 border-b border-gray-50">
            <span class="text-sm text-gray-500">Empresas Não Verificadas</span>
            <span class="text-sm font-semibold text-terracota bg-terracota/10 px-2.5 py-0.5 rounded-full">{{ $stats['unverified_companies'] ?? 0 }}</span>
        </div>
        <div class="flex items-center justify-between py-3 border-b border-gray-50">
            <span class="text-sm text-gray-500">Concursos Activos</span>
            <span class="text-sm font-semibold text-forest-green bg-forest-green/10 px-2.5 py-0.5 rounded-full">{{ $stats['active_contests'] ?? 0 }}</span>
        </div>
        <div class="flex items-center justify-between py-3">
            <span class="text-sm text-gray-500">Total Candidaturas</span>
            <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">{{ $stats['total_applications'] ?? 0 }}</span>
        </div>
    </div>

</div>

{{-- Recent Contests Table --}}
<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-base font-semibold text-gray-700">Concursos Recentes</h2>
        <a href="{{ route('admin.contests.index') }}" class="text-sm text-terracota hover:underline font-medium">Ver todos</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Título</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Empresa</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Criado em</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentContests ?? [] as $contest)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $contest->title }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $contest->company->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = [
                                    'pending'  => ['label' => 'Pendente',  'class' => 'bg-yellow-100 text-yellow-700'],
                                    'active'   => ['label' => 'Activo',    'class' => 'bg-green-100 text-green-700'],
                                    'closed'   => ['label' => 'Fechado',   'class' => 'bg-gray-100 text-gray-600'],
                                    'rejected' => ['label' => 'Rejeitado', 'class' => 'bg-red-100 text-red-600'],
                                ];
                                $s = $statusMap[$contest->status] ?? ['label' => ucfirst($contest->status), 'class' => 'bg-gray-100 text-gray-600'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $s['class'] }}">
                                {{ $s['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $contest->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($contest->status === 'pending')
                                    <form method="POST" action="{{ route('admin.contests.approve', $contest) }}">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg bg-forest-green text-white hover:bg-green-800 transition">
                                            Aprovar
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.contests.reject', $contest) }}">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition">
                                            Rejeitar
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.contests.index') }}"
                                       class="text-xs text-gray-400 hover:text-gray-600 transition">Ver</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">Nenhum concurso encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const ctx = document.getElementById('userGrowthChart');
    if (!ctx) return;

    const chartData = @json($chartData ?? ['labels' => [], 'data' => []]);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels ?? [],
            datasets: [{
                label: 'Novos Utilizadores',
                data: chartData.data ?? [],
                borderColor: '#C0602A',
                backgroundColor: 'rgba(192,96,42,0.08)',
                borderWidth: 2,
                pointBackgroundColor: '#C0602A',
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a2e',
                    titleColor: '#F5E6C8',
                    bodyColor: '#ccc',
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { color: '#9ca3af', font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { color: '#9ca3af', font: { size: 11 } }
                }
            }
        }
    });
})();
</script>
@endpush
