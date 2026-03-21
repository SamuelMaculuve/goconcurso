@extends('layouts.admin')

@section('title', 'Concurso')
@section('page-title', 'Concurso')
@section('page-subtitle', 'Moderação e gestão de Concurso')

@section('content')

{{-- Status Filter Tabs --}}
@php
    $statusTabs = [
        ''         => 'Todos',
        'pending'  => 'Pendentes',
        'active'   => 'Activos',
        'closed'   => 'Fechados',
        'rejected' => 'Rejeitados',
    ];
@endphp
<div class="flex gap-2 mb-6 flex-wrap">
    @foreach($statusTabs as $value => $label)
        <a href="{{ route('admin.contests.index', array_merge(request()->query(), ['status' => $value])) }}"
           class="px-4 py-2 rounded-full text-sm font-medium transition
                  {{ request('status', '') === $value
                     ? 'bg-terracota text-white'
                     : 'bg-white text-gray-600 border border-gray-200 hover:border-terracota hover:text-terracota' }}">
            {{ $label }}
            @if(isset($statusCounts[$value]))
                <span class="ml-1 text-xs opacity-75">({{ $statusCounts[$value] }})</span>
            @endif
        </a>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Título</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Empresa</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Categoria</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prazo</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($contests ?? [] as $contest)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800 max-w-xs truncate">{{ $contest->title }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $contest->company->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $contest->contest_type ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $contest->category->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $contest->deadline ? $contest->deadline->format('d/m/Y') : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = [
                                    'pending'  => ['Pendente',  'bg-yellow-100 text-yellow-700'],
                                    'active'   => ['Activo',    'bg-green-100 text-green-700'],
                                    'closed'   => ['Fechado',   'bg-gray-100 text-gray-600'],
                                    'rejected' => ['Rejeitado', 'bg-red-100 text-red-600'],
                                ];
                                [$statusLabel, $statusClass] = $statusMap[$contest->status] ?? [ucfirst($contest->status), 'bg-gray-100 text-gray-600'];
                            @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
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
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg bg-orange-100 text-orange-600 hover:bg-orange-200 transition">
                                            Rejeitar
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.contests.destroy', $contest) }}"
                                      onsubmit="return confirm('Eliminar este concurso permanentemente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">
                            Nenhum concurso encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($contests) && $contests->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $contests->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
