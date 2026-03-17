@extends('layouts.company')

@section('title', 'Propostas Recebidas')
@section('page-title', 'Propostas Recebidas')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">
        <span class="font-semibold text-gray-800">{{ $applications->total() ?? 0 }}</span> proposta(s) recebida(s)
        @if(isset($contest))
            para <span class="font-semibold text-forest-green">{{ $contest->title }}</span>
        @endif
    </p>
    <a href="{{ route('company.contests.index') }}"
       class="flex items-center gap-1 text-sm text-gray-500 hover:text-forest-green transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Proponente</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Concurso</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Data</th>
                <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($applications ?? [] as $application)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-sand flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-terracota">
                                    {{ strtoupper(substr($application->user->name ?? 'U', 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $application->user->name ?? '–' }}</p>
                                <p class="text-xs text-gray-400">{{ $application->user->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <span class="text-sm text-gray-700 line-clamp-1">
                            {{ $application->contest->title ?? '–' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <x-badge :type="$application->status ?? 'pending'" :label="$application->status_label ?? 'Pendente'" />
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell">
                        <span class="text-xs text-gray-500">
                            {{ isset($application->created_at) ? \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') : '–' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Proposal doc download --}}
                            @if($application->cv_path ?? false)
                                <a href="{{ Storage::url($application->cv_path) }}" target="_blank"
                                   class="p-1.5 text-gray-400 hover:text-forest-green hover:bg-green-50 rounded-lg transition"
                                   title="Ver Proposta Técnica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                            @endif

                            {{-- Status update dropdown --}}
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                        class="p-1.5 text-gray-400 hover:text-terracota hover:bg-orange-50 rounded-lg transition"
                                        title="Alterar Estado">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition
                                     class="absolute right-0 mt-1 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-1 z-20">
                                    @foreach(['pending' => 'Pendente', 'reviewing' => 'Em Análise', 'accepted' => 'Seleccionada', 'rejected' => 'Rejeitada'] as $status => $label)
                                        <form method="POST"
                                              action="{{ route('company.contests.applications.status', [$application->contest_id, $application->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ $status }}">
                                            <button type="submit"
                                                    class="w-full text-left px-4 py-2 text-xs hover:bg-gray-50 transition
                                                           {{ $application->status === $status ? 'font-bold text-forest-green' : 'text-gray-700' }}">
                                                {{ $label }}
                                            </button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Nenhuma proposta recebida ainda</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($applications) && $applications->hasPages())
    <div class="mt-4">{{ $applications->links() }}</div>
@endif

@endsection
