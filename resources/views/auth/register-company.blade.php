@extends('layouts.guest')

@section('title', 'Registar Empresa')
@section('card_width', 'max-w-2xl')

@php
    // If validation errors belong to step 2 fields, resume on step 2
    $initialStep = ($errors->hasAny(['company_name', 'country', 'city', 'sector', 'company_type', 'company_role'])) ? 2 : 1;
@endphp

@section('content')
<div x-data="{
    step: {{ $initialStep }},
    loading: false,
    showPass: false,
    showConfirm: false,
    nextStep() {
        const name  = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const pass  = document.getElementById('password').value;
        const conf  = document.getElementById('password_confirmation').value;

        if (!name || !email || !pass || !conf) {
            alert('Por favor preencha todos os campos obrigatórios.');
            return;
        }
        if (pass.length < 8) {
            alert('A palavra-passe deve ter no mínimo 8 caracteres.');
            return;
        }
        if (pass !== conf) {
            alert('As palavras-passe não coincidem.');
            return;
        }
        this.step = 2;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}">

    {{-- Step indicator --}}
    <div class="flex items-center justify-center mb-8">
        <div class="flex items-center">
            <div
                class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                :class="step >= 1 ? 'bg-terracota text-white' : 'bg-gray-200 text-gray-500'"
            >1</div>
            <span
                class="ml-2 text-sm font-medium transition-colors hidden sm:inline"
                :class="step >= 1 ? 'text-terracota' : 'text-gray-400'"
            >Dados pessoais</span>
        </div>
        <div class="w-12 sm:w-20 h-0.5 mx-3 transition-colors" :class="step >= 2 ? 'bg-forest-green' : 'bg-gray-200'"></div>
        <div class="flex items-center">
            <div
                class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                :class="step >= 2 ? 'bg-forest-green text-white' : 'bg-gray-200 text-gray-500'"
            >2</div>
            <span
                class="ml-2 text-sm font-medium transition-colors hidden sm:inline"
                :class="step >= 2 ? 'text-forest-green' : 'text-gray-400'"
            >Dados da empresa</span>
        </div>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
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

    <form @submit.prevent="loading = true; $el.submit()" method="POST" action="{{ route('register.company.post') }}">
        @csrf

        {{-- ── STEP 1: Personal data ───────────────────────────────────── --}}
        <div x-show="step === 1" x-transition.opacity>
            <h2 class="text-base font-semibold text-gray-700 mb-5 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-terracota flex items-center justify-center text-white text-xs font-bold">1</span>
                Dados do utilizador responsável
            </h2>

            <div class="space-y-4">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nome completo <span class="text-red-500">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-terracota focus:border-transparent transition
                            {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="O seu nome completo"/>
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email profissional <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-terracota focus:border-transparent transition
                            {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="gestor@empresa.com"/>
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Passwords --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Palavra-passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" id="password" name="password" required autocomplete="new-password"
                                class="w-full rounded-lg border px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-terracota focus:border-transparent transition
                                    {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                                placeholder="Mínimo 8 caracteres"/>
                            <button type="button" @click="showPass = !showPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition" tabindex="-1">
                                <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Confirmar palavra-passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 pr-10 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-terracota focus:border-transparent transition"
                                placeholder="Repita a palavra-passe"/>
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition" tabindex="-1">
                                <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" @click="nextStep()"
                class="mt-6 w-full bg-terracota hover:bg-[#a8521f] text-white font-semibold py-2.5 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracota flex items-center justify-center gap-2">
                Continuar para dados da empresa
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        {{-- ── STEP 2: Company data ────────────────────────────────────── --}}
        <div x-show="step === 2" x-transition.opacity>
            <div class="flex items-center gap-3 mb-5">
                <button type="button" @click="step = 1"
                    class="text-sm text-gray-500 hover:text-gray-700 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Voltar
                </button>
                <h2 class="text-base font-semibold text-gray-700 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-forest-green flex items-center justify-center text-white text-xs font-bold">2</span>
                    Dados da empresa
                </h2>
            </div>

            <div class="space-y-4">
                {{-- Company name --}}
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nome da empresa <span class="text-red-500">*</span>
                    </label>
                    <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" required
                        class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-forest-green focus:border-transparent transition
                            {{ $errors->has('company_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="Nome oficial da sua empresa"/>
                    @error('company_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Country --}}
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1.5">
                            País <span class="text-red-500">*</span>
                        </label>
                        <input id="country" type="text" name="country" value="{{ old('country') }}" required
                            class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-forest-green focus:border-transparent transition
                                {{ $errors->has('country') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                            placeholder="ex: Angola, Moçambique"/>
                        @error('country')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Cidade <span class="text-red-500">*</span>
                        </label>
                        <input id="city" type="text" name="city" value="{{ old('city') }}" required
                            class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-forest-green focus:border-transparent transition
                                {{ $errors->has('city') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                            placeholder="Cidade principal"/>
                        @error('city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Sector --}}
                    <div>
                        <label for="sector" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Sector de actividade
                        </label>
                        <input id="sector" type="text" name="sector" value="{{ old('sector') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-forest-green focus:border-transparent transition"
                            placeholder="ex: Tecnologia, Saúde"/>
                    </div>

                    {{-- Company type --}}
                    <div>
                        <label for="company_type" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Tipo de empresa <span class="text-red-500">*</span>
                        </label>
                        <select id="company_type" name="company_type" required
                            class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-forest-green focus:border-transparent transition bg-white
                                {{ $errors->has('company_type') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            <option value="" disabled {{ old('company_type') ? '' : 'selected' }}>Selecione o tipo</option>
                            <option value="private"       {{ old('company_type') === 'private'       ? 'selected' : '' }}>Empresa privada</option>
                            <option value="public"        {{ old('company_type') === 'public'        ? 'selected' : '' }}>Empresa pública</option>
                            <option value="ngo"           {{ old('company_type') === 'ngo'           ? 'selected' : '' }}>ONG / Associação</option>
                            <option value="international" {{ old('company_type') === 'international' ? 'selected' : '' }}>Organização internacional</option>
                        </select>
                        @error('company_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Company role --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Função na plataforma <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach([
                            'buyer'    => ['label' => 'Comprador / Contratante', 'desc' => 'Publico Concurso para adquirir bens ou serviços', 'icon' => '🏢'],
                            'supplier' => ['label' => 'Fornecedor / Prestador',  'desc' => 'Apresento propostas em Concurso publicados',      'icon' => '🔧'],
                            'both'     => ['label' => 'Ambos',                   'desc' => 'Compro e também forneço bens e serviços',           'icon' => '🔄'],
                        ] as $value => $opt)
                            <label class="relative flex cursor-pointer rounded-xl border-2 p-4 transition
                                {{ old('company_role') === $value
                                    ? 'border-forest-green bg-forest-green/5'
                                    : 'border-gray-200 hover:border-forest-green/50' }}">
                                <input type="radio" name="company_role" value="{{ $value }}"
                                    {{ old('company_role') === $value ? 'checked' : '' }}
                                    class="sr-only peer" required/>
                                <div class="flex-1">
                                    <span class="text-xl">{{ $opt['icon'] }}</span>
                                    <p class="text-sm font-semibold text-gray-800 mt-1">{{ $opt['label'] }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 leading-snug">{{ $opt['desc'] }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('company_role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" :disabled="loading"
                class="mt-6 w-full bg-forest-green hover:bg-[#245a42] disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold py-2.5 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-forest-green flex items-center justify-center gap-2">
                <svg x-show="loading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <span x-text="loading ? 'A registar empresa...' : 'Registar empresa'"></span>
            </button>
        </div>

    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Já tem conta?
        <a href="{{ route('login') }}" class="text-terracota font-medium hover:underline">Entrar</a>
    </div>

</div>
@endsection
