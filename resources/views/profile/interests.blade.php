@extends('layouts.app')

@section('title', 'Interesses Enviados')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Interesses Enviados</h1>
        </div>
        @if(isset($interests) && $interests->total() > 0)
            <span class="text-sm text-gray-500">{{ $interests->total() }} interesse(s) registado(s)</span>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        @if(isset($interests) && $interests->count())

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide">Concurso</th>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide hidden sm:table-cell">Empresa</th>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide">Estado</th>
                            <th class="text-left py-3 px-5 text-gray-500 font-medium text-xs uppercase tracking-wide hidden md:table-cell">Enviado em</th>
                            <th class="py-3 px-5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($interests as $interest)
                            @php
                                $colors = [
                                    'new'       => 'bg-blue-100 text-blue-700',
                                    'viewed'    => 'bg-yellow-100 text-yellow-700',
                                    'contacted' => 'bg-green-100 text-green-700',
                                    'closed'    => 'bg-gray-100 text-gray-500',
                                ];
                                $labels = [
                                    'new'       => 'Novo',
                                    'viewed'    => 'Visto',
                                    'contacted' => 'Contactado',
                                    'closed'    => 'Encerrado',
                                ];
                                $color = $colors[$interest->status] ?? 'bg-gray-100 text-gray-600';
                                $label = $labels[$interest->status] ?? ucfirst($interest->status);
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-5">
                                    <a href="{{ route('contests.show', $interest->contest->slug) }}"
                                        class="font-medium text-gray-800 hover:text-[#C0602A] transition line-clamp-1 block max-w-xs">
                                        {{ $interest->contest->title ?? '—' }}
                                    </a>
                                    @if($interest->contest->deadline ?? false)
                                        <span class="text-xs text-gray-400 mt-0.5 block">
                                            Prazo: {{ \Carbon\Carbon::parse($interest->contest->deadline)->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-gray-600 hidden sm:table-cell">
                                    {{ $interest->contest->company->name ?? '—' }}
                                </td>
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-gray-400 text-xs hidden md:table-cell">
                                    {{ $interest->created_at->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <a href="{{ route('contests.show', $interest->contest->slug) }}"
                                        class="text-xs text-[#C0602A] hover:underline whitespace-nowrap">
                                        Ver concurso
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($interests->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $interests->links() }}
                </div>
            @endif

        @else
            {{-- Empty state --}}
            <div class="text-center py-16 px-4">
                <div class="w-16 h-16 bg-[#F5E6C8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#2D6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Nenhum interesse submetido</h3>
                <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">
                    Ainda nao manifestou interesse em nenhum concurso. Explore as oportunidades disponiveis e registe o seu interesse.
                </p>
                <a href="{{ route('contests.index') }}"
                    class="inline-flex items-center gap-2 bg-[#2D6A4F] hover:bg-[#245a42] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Explorar concursos
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
