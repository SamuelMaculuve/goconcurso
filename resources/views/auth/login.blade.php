@extends('layouts.guest')

@section('title', 'Entrar na conta')

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
            <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Entrar na conta</h1>

            {{-- Session Errors --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4">
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Status message --}}
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
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
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('email') border-red-400 @enderror"
                        placeholder="o.seu@email.com"
                    />
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Palavra-passe
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-[#C0602A] hover:underline">
                                Esqueceu a palavra-passe?
                            </a>
                        @endif
                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('password') border-red-400 @enderror"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center mb-6">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 rounded border-gray-300 text-[#C0602A] focus:ring-[#C0602A]" />
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">Lembrar-me</label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[#C0602A] hover:bg-[#a8521f] text-white font-semibold py-2.5 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C0602A]"
                >
                    Entrar
                </button>
            </form>

            {{-- Register link --}}
            <p class="mt-6 text-center text-sm text-gray-600">
                Ainda não tem conta?
                <a href="{{ route('register') }}" class="text-[#C0602A] font-medium hover:underline">
                    Criar conta
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
