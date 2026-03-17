@extends('layouts.app')

@section('title', 'Concursos Guardados')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Concursos Guardados</h1>
        </div>
        @if(isset($savedContests) && $savedContests->total() > 0)
            <span class="text-sm text-gray-500">{{ $savedContests->total() }} guardado(s)</span>
        @endif
    </div>

    @if(isset($savedContests) && $savedContests->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($savedContests as $saved)
                <x-contest-card :contest="$saved->contest" />
            @endforeach
        </div>
        @if($savedContests->hasPages())
            <div class="mt-6">{{ $savedContests->links() }}</div>
        @endif
    @else
        {{-- Empty state --}}
        <div class="bg-white rounded-2xl shadow text-center py-16 px-4">
            <div class="w-16 h-16 bg-[#F5E6C8] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Nenhum concurso guardado</h3>
            <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">
                Guarde concursos interessantes para os rever mais tarde. Clique no icone de marcador em qualquer concurso.
            </p>
            <a href="{{ route('contests.index') }}"
                class="inline-flex items-center gap-2 bg-[#C0602A] hover:bg-[#a8521f] text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Explorar concursos
            </a>
        </div>
    @endif

</div>
@endsection
