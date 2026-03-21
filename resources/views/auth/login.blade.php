@extends('layouts.guest')

@section('title', 'Entrar na conta')

@section('content')
<div x-data="{ loading: false, showPassword: false }">

    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Entrar na conta</h1>
        <p class="mt-1 text-sm text-gray-500">Bem-vindo de volta ao Concurso</p>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <ul class="text-sm text-red-700 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Status message --}}
    @if (session('status'))
        <div class="mb-5 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form @submit.prevent="loading = true; $el.submit()" method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                Endereço de email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-terracota focus:border-transparent transition
                    {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                placeholder="o.seu@email.com"
            />
            @error('email')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Palavra-passe
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-terracota hover:underline">
                        Esqueceu a palavra-passe?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-lg border px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-terracota focus:border-transparent transition
                        {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    placeholder="••••••••"
                />
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
                    tabindex="-1"
                    aria-label="Mostrar/ocultar palavra-passe"
                >
                    {{-- Eye icon --}}
                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{-- Eye-off icon --}}
                    <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center mb-6">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="h-4 w-4 rounded border-gray-300 text-terracota focus:ring-terracota"
            />
            <label for="remember_me" class="ml-2 text-sm text-gray-600">Lembrar-me</label>
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            :disabled="loading"
            class="w-full bg-terracota hover:bg-[#a8521f] disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold py-2.5 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracota flex items-center justify-center gap-2"
        >
            <svg x-show="loading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <span x-text="loading ? 'A entrar...' : 'Entrar'"></span>
        </button>
    </form>

    {{-- Links --}}
    <div class="mt-6 space-y-2 text-center text-sm text-gray-600">
        <p>
            Ainda não tem conta?
            <a href="{{ route('register') }}" class="text-terracota font-medium hover:underline">
                Criar conta de candidato
            </a>
        </p>
        <p>
            É uma empresa?
            <a href="{{ route('register.company') }}" class="text-forest-green font-medium hover:underline">
                Registar empresa
            </a>
        </p>
    </div>

</div>
@endsection
