@extends('layouts.app')

@section('title', 'Candidatura — ' . $contest->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    @auth
        {{-- Contest header --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-xl bg-[#2D6A4F] flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                    {{ strtoupper(substr($contest->company->name ?? 'G', 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $contest->title }}</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ $contest->company->name ?? '—' }} •
                        {{ $contest->city }}, {{ $contest->country }} •
                        Prazo: <strong class="text-[#C0602A]">{{ $contest->deadline ? $contest->deadline->format('d/m/Y') : '—' }}</strong>
                    </p>
                    @if($contest->vacancies_count)
                        <span class="inline-block mt-2 bg-[#2D6A4F] text-white text-xs px-3 py-1 rounded-full">
                            {{ $contest->vacancies_count }} vaga(s)
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Application form (Livewire) --}}
        @livewire('application-form', ['contest' => $contest])
    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-10 text-center">
            <span class="text-5xl">🔐</span>
            <h2 class="text-xl font-bold text-gray-800 mt-4 mb-2">Precisa de estar autenticado</h2>
            <p class="text-gray-500 mb-6">Para se candidatar a este concurso, precisa de iniciar sessão ou criar uma conta.</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('login') }}" class="bg-[#C0602A] text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-[#a0501f]">
                    Entrar
                </a>
                <a href="{{ route('register') }}" class="border-2 border-[#C0602A] text-[#C0602A] px-6 py-2.5 rounded-lg font-semibold hover:bg-[#C0602A] hover:text-white transition-colors">
                    Criar Conta
                </a>
            </div>
        </div>
    @endauth
</div>
@endsection
