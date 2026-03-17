@extends('layouts.guest')

@section('title', 'Criar Conta de Candidato')

@section('content')
<div class="min-h-screen bg-[#F5E6C8] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <div class="flex items-center justify-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-[#C0602A] flex items-center justify-center">
                        <span class="text-white font-bold text-lg">G</span>
                    </div>
                    <span class="text-2xl font-bold text-[#2D6A4F]">GoConcursos</span>
                </div>
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-800 text-center mb-2">Criar Conta de Candidato</h1>
            <p class="text-sm text-gray-500 text-center mb-6">Candidate-se a concursos em toda a África</p>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4">
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nome completo
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('name') border-red-400 @enderror"
                        placeholder="O seu nome completo"
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Endereço de email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('email') border-red-400 @enderror"
                        placeholder="o.seu@email.com"
                    />
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Palavra-passe
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('password') border-red-400 @enderror"
                        placeholder="Mínimo 8 caracteres"
                    />
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Confirmation --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmar palavra-passe
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('password_confirmation') border-red-400 @enderror"
                        placeholder="Repita a palavra-passe"
                    />
                    @error('password_confirmation')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[#C0602A] hover:bg-[#a8521f] text-white font-semibold py-2.5 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C0602A]"
                >
                    Criar conta
                </button>
            </form>

            {{-- Links --}}
            <div class="mt-6 space-y-2 text-center text-sm text-gray-600">
                <p>
                    Já tem conta?
                    <a href="{{ route('login') }}" class="text-[#C0602A] font-medium hover:underline">Entrar</a>
                </p>
                <p>
                    É uma empresa?
                    <a href="{{ route('register.company') }}" class="text-[#2D6A4F] font-medium hover:underline">
                        Registar empresa
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
