@extends('layouts.company')

@section('title', 'Meus Concurso')
@section('page-title', 'Meus Concurso')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">
        {{ $contests->total() ?? 0 }} concurso(s) encontrado(s)
    </p>
    <a href="{{ route('company.contests.create') }}"
       class="flex items-center gap-2 bg-forest-green text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-green-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Novo Concurso
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Título</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Categoria</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Prazo</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Candidaturas</th>
                <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($contests ?? [] as $contest)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <div>
                            <a href="{{ route('contests.show', $contest->slug) }}"
                               class="font-semibold text-gray-900 hover:text-forest-green transition line-clamp-1">
                                {{ $contest->title }}
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5 md:hidden">{{ $contest->category->name ?? '–' }}</p>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <x-badge :type="$contest->category->slug ?? 'default'" :label="$contest->category->name ?? '–'" />
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell">
                        @if($contest->deadline)
                            <span class="text-xs {{ \Carbon\Carbon::parse($contest->deadline)->isPast() ? 'text-red-500' : 'text-gray-600' }}">
                                {{ \Carbon\Carbon::parse($contest->deadline)->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-xs text-gray-400">–</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <x-badge :type="$contest->status ?? 'draft'" :label="$contest->status_label ?? 'Rascunho'" />
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell">
                        <span class="text-sm font-semibold text-gray-700">{{ $contest->applications_count ?? 0 }}</span>
                        <span class="text-xs text-gray-400 ml-1">candidatura(s)</span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('company.contests.edit', $contest->id) }}"
                               class="p-1.5 text-gray-400 hover:text-forest-green hover:bg-green-50 rounded-lg transition"
                               title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <a href="{{ route('company.contests.applications', $contest->id) }}"
                               class="p-1.5 text-gray-400 hover:text-terracota hover:bg-orange-50 rounded-lg transition"
                               title="Candidaturas">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('company.contests.destroy', $contest->id) }}"
                                  onsubmit="return confirm('Tem a certeza que deseja eliminar este concurso?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"
                                        title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-sm text-gray-400 mb-3">Ainda não publicou nenhum concurso</p>
                        <a href="{{ route('company.contests.create') }}"
                           class="inline-flex items-center gap-2 bg-forest-green text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-green-800 transition">
                            Publicar Primeiro Concurso
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if(isset($contests) && $contests->hasPages())
    <div class="mt-4">
        {{ $contests->links() }}
    </div>
@endif

@endsection
