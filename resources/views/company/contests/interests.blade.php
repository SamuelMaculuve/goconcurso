@extends('layouts.company')

@section('title', 'Interessados')
@section('page-title', 'Interessados')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-sm text-gray-500">
            <span class="font-semibold text-gray-800">{{ $interests->total() ?? 0 }}</span> interesse(s) recebido(s)
            @if(isset($contest))
                no concurso <span class="font-semibold text-forest-green">{{ $contest->title }}</span>
            @endif
        </p>
    </div>
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
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidato</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Concurso</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Mensagem</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Data</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($interests ?? [] as $interest)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-sand flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-terracota">
                                    {{ strtoupper(substr($interest->user->name ?? 'U', 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $interest->user->name ?? '–' }}</p>
                                <p class="text-xs text-gray-400">{{ $interest->user->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <span class="text-sm text-gray-700 line-clamp-1">
                            {{ $interest->contest->title ?? '–' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell">
                        <p class="text-xs text-gray-500 line-clamp-2 max-w-xs">
                            {{ $interest->message ?? '–' }}
                        </p>
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-xs text-gray-500">
                            {{ isset($interest->created_at) ? \Carbon\Carbon::parse($interest->created_at)->format('d/m/Y') : '–' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-16 text-center">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Nenhum interesse recebido ainda</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($interests) && $interests->hasPages())
    <div class="mt-4">{{ $interests->links() }}</div>
@endif

@endsection
