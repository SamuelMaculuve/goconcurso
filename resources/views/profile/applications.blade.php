@extends('layouts.app')

@section('title', 'As minhas propostas')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">As minhas propostas</h1>
        </div>
        @if(isset($applications) && $applications->total() > 0)
            <span class="text-sm text-gray-500">{{ $applications->total() }} proposta(s) no total</span>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        @if(isset($applications) && $applications->count())

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide">Concurso</th>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide hidden sm:table-cell">Empresa</th>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide">Estado</th>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide hidden md:table-cell">Candidatura</th>
                            <th class="py-3 px-5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($applications as $application)
                            @php
                                $statusColors = [
                                    'pending'   => 'bg-yellow-100 text-yellow-700',
                                    'reviewing' => 'bg-blue-100 text-blue-700',
                                    'reviewed'  => 'bg-blue-100 text-blue-700',
                                    'accepted'  => 'bg-green-100 text-green-700',
                                    'rejected'  => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending'   => 'Pendente',
                                    'reviewing' => 'Em analise',
                                    'reviewed'  => 'Em analise',
                                    'accepted'  => 'Aceite',
                                    'rejected'  => 'Rejeitado',
                                ];
                                $color = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-600';
                                $label = $statusLabels[$application->status] ?? ucfirst($application->status);
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-5">
                                    <a href="{{ route('contests.show', $application->contest->slug) }}"
                                        class="font-medium text-gray-800 hover:text-[#C0602A] transition line-clamp-1 block max-w-xs">
                                        {{ $application->contest->title ?? '—' }}
                                    </a>
                                    @if($application->contest->location ?? false)
                                        <span class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $application->contest->location }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-gray-600 hidden sm:table-cell">
                                    {{ $application->contest->company->name ?? '—' }}
                                </td>
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-gray-400 text-xs hidden md:table-cell">
                                    {{ $application->created_at->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <a href="{{ route('contests.show', $application->contest->slug) }}"
                                        class="text-xs text-[#C0602A] hover:underline whitespace-nowrap">
                                        Ver concurso
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($applications->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $applications->links() }}
                </div>
            @endif

        @else
            {{-- Empty state --}}
            <div class="text-center py-16 px-4">
                <div class="w-16 h-16 bg-[#F5E6C8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Nenhuma proposta submetida ainda</h3>
                <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">
                    Ainda não submeteu nenhuma proposta. Explore os Concurso disponíveis e apresente a sua proposta hoje.
                </p>
                <a href="{{ route('contests.index') }}"
                    class="inline-flex items-center gap-2 bg-[#C0602A] hover:bg-[#a8521f] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Explorar Concurso
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
