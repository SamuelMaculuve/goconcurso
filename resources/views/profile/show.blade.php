@extends('layouts.app')

@section('title', $user->name . ' — Perfil')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Profile Header --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">

            {{-- Avatar --}}
            <div class="flex-shrink-0">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                        class="w-24 h-24 rounded-full object-cover ring-4 ring-[#F5E6C8]" />
                @else
                    <div class="w-24 h-24 rounded-full bg-[#C0602A] flex items-center justify-center ring-4 ring-[#F5E6C8]">
                        <span class="text-3xl font-bold text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 text-center sm:text-left">
                <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>

                <div class="flex flex-wrap justify-center sm:justify-start gap-4 mt-3 text-sm text-gray-600">
                    @if ($user->city || $user->country)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ collect([$user->city, $user->country])->filter()->implode(', ') }}
                        </span>
                    @endif
                    @if ($user->professional_area)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-[#2D6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $user->professional_area }}
                        </span>
                    @endif
                </div>

                @if ($user->bio)
                    <p class="mt-3 text-sm text-gray-600 max-w-prose">{{ $user->bio }}</p>
                @endif
            </div>

            {{-- Edit button --}}
            <div class="flex-shrink-0">
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center gap-2 border border-[#C0602A] text-[#C0602A] hover:bg-[#C0602A] hover:text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Editar perfil
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <div class="text-3xl font-bold text-[#C0602A]">{{ $applicationsCount ?? 0 }}</div>
            <div class="text-sm text-gray-500 mt-1">Propostas</div>
            <a href="{{ route('profile.applications') }}" class="text-xs text-[#C0602A] hover:underline mt-1 inline-block">Ver todas</a>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <div class="text-3xl font-bold text-[#D4A017]">{{ $savedCount ?? 0 }}</div>
            <div class="text-sm text-gray-500 mt-1">Guardados</div>
            <a href="{{ route('profile.saved') }}" class="text-xs text-[#D4A017] hover:underline mt-1 inline-block">Ver todos</a>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <div class="text-3xl font-bold text-[#2D6A4F]">{{ $interestsCount ?? 0 }}</div>
            <div class="text-sm text-gray-500 mt-1">Interesses</div>
            <a href="{{ route('profile.interests') }}" class="text-xs text-[#2D6A4F] hover:underline mt-1 inline-block">Ver todos</a>
        </div>
    </div>

    {{-- Recent Applications --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-semibold text-gray-800">Propostas recentes</h2>
            <a href="{{ route('profile.applications') }}" class="text-sm text-[#C0602A] hover:underline">Ver todas</a>
        </div>

        @if (isset($recentApplications) && $recentApplications->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-2 px-3 text-gray-500 font-medium">Concurso</th>
                            <th class="text-left py-2 px-3 text-gray-500 font-medium hidden sm:table-cell">Empresa</th>
                            <th class="text-left py-2 px-3 text-gray-500 font-medium">Estado</th>
                            <th class="text-left py-2 px-3 text-gray-500 font-medium hidden md:table-cell">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($recentApplications as $application)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-3">
                                    <a href="{{ route('contests.show', $application->contest->slug) }}"
                                        class="font-medium text-gray-800 hover:text-[#C0602A] line-clamp-1">
                                        {{ $application->contest->title ?? '—' }}
                                    </a>
                                </td>
                                <td class="py-3 px-3 text-gray-500 hidden sm:table-cell">
                                    {{ $application->contest->company->name ?? '—' }}
                                </td>
                                <td class="py-3 px-3">
                                    @php
                                        $statusColors = [
                                            'pending'  => 'bg-yellow-100 text-yellow-700',
                                            'reviewed' => 'bg-blue-100 text-blue-700',
                                            'accepted' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending'  => 'Pendente',
                                            'reviewed' => 'Em análise',
                                            'accepted' => 'Aceite',
                                            'rejected' => 'Rejeitado',
                                        ];
                                        $color = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-600';
                                        $label = $statusLabels[$application->status] ?? ucfirst($application->status);
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-gray-400 text-xs hidden md:table-cell">
                                    {{ $application->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-10 text-gray-400">
                <div class="text-4xl mb-3">📋</div>
                <p class="text-sm">Ainda não submeteu propostas.</p>
                <a href="{{ route('contests.index') }}" class="mt-3 inline-block text-sm text-[#C0602A] hover:underline">
                    Explorar concursos
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
