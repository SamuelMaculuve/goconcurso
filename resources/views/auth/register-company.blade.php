@extends('layouts.guest')

@section('title', 'Registar Empresa')

@section('content')
<div class="min-h-screen bg-[#F5E6C8] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-2xl">

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
            <h1 class="text-2xl font-bold text-gray-800 text-center mb-2">Registar Empresa</h1>
            <p class="text-sm text-gray-500 text-center mb-8">Publique concursos de fornecimento e encontre os melhores fornecedores em África</p>

            {{-- Step indicators --}}
            <div class="flex items-center justify-center mb-8 gap-0">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-[#C0602A] flex items-center justify-center text-white text-sm font-bold">1</div>
                    <span class="ml-2 text-sm font-medium text-[#C0602A]">Dados pessoais</span>
                </div>
                <div class="w-16 h-0.5 bg-gray-300 mx-3"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-[#2D6A4F] flex items-center justify-center text-white text-sm font-bold">2</div>
                    <span class="ml-2 text-sm font-medium text-[#2D6A4F]">Dados da empresa</span>
                </div>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.company.post') }}">
                @csrf

                {{-- Section 1: User data --}}
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-6 h-6 rounded-full bg-[#C0602A] flex items-center justify-center text-white text-xs font-bold">1</div>
                        <h2 class="text-base font-semibold text-gray-700">Dados do utilizador responsável</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Name --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                            <input
                                id="name" type="text" name="name" value="{{ old('name') }}"
                                required autofocus
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('name') border-red-400 @enderror"
                                placeholder="O seu nome completo"
                            />
                            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email profissional</label>
                            <input
                                id="email" type="email" name="email" value="{{ old('email') }}"
                                required autocomplete="email"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('email') border-red-400 @enderror"
                                placeholder="gestor@empresa.com"
                            />
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Palavra-passe</label>
                            <input
                                id="password" type="password" name="password"
                                required autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('password') border-red-400 @enderror"
                                placeholder="Mínimo 8 caracteres"
                            />
                            @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Password confirmation --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar palavra-passe</label>
                            <input
                                id="password_confirmation" type="password" name="password_confirmation"
                                required autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition"
                                placeholder="Repita a palavra-passe"
                            />
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200 mb-8"></div>

                {{-- Section 2: Company data --}}
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-6 h-6 rounded-full bg-[#2D6A4F] flex items-center justify-center text-white text-xs font-bold">2</div>
                        <h2 class="text-base font-semibold text-gray-700">Dados da empresa</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Company name --}}
                        <div class="md:col-span-2">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Nome da empresa</label>
                            <input
                                id="company_name" type="text" name="company_name" value="{{ old('company_name') }}"
                                required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent transition @error('company_name') border-red-400 @enderror"
                                placeholder="Nome da sua empresa"
                            />
                            @error('company_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Country --}}
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">País</label>
                            <input
                                id="country" type="text" name="country" value="{{ old('country') }}"
                                required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent transition @error('country') border-red-400 @enderror"
                                placeholder="ex: Angola, Moçambique"
                            />
                            @error('country')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- City --}}
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                            <input
                                id="city" type="text" name="city" value="{{ old('city') }}"
                                required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent transition @error('city') border-red-400 @enderror"
                                placeholder="Cidade principal"
                            />
                            @error('city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Sector --}}
                        <div>
                            <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Sector de actividade</label>
                            <input
                                id="sector" type="text" name="sector" value="{{ old('sector') }}"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent transition @error('sector') border-red-400 @enderror"
                                placeholder="ex: Tecnologia, Saúde"
                            />
                            @error('sector')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Company type --}}
                        <div>
                            <label for="company_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de empresa</label>
                            <select
                                id="company_type" name="company_type"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent transition bg-white @error('company_type') border-red-400 @enderror"
                            >
                                <option value="" disabled {{ old('company_type') ? '' : 'selected' }}>Selecione o tipo</option>
                                <option value="private" {{ old('company_type') === 'private' ? 'selected' : '' }}>Empresa privada</option>
                                <option value="public" {{ old('company_type') === 'public' ? 'selected' : '' }}>Empresa pública</option>
                                <option value="ngo" {{ old('company_type') === 'ngo' ? 'selected' : '' }}>ONG / Associação</option>
                                <option value="international" {{ old('company_type') === 'international' ? 'selected' : '' }}>Organização internacional</option>
                            </select>
                            @error('company_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Company role --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Função na plataforma <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach(['buyer' => ['label' => 'Comprador / Contratante', 'desc' => 'Publico concursos para adquirir bens ou serviços', 'icon' => '🏢'], 'supplier' => ['label' => 'Fornecedor / Prestador', 'desc' => 'Apresento propostas em concursos publicados', 'icon' => '🔧'], 'both' => ['label' => 'Ambos', 'desc' => 'Compro e também forneço bens e serviços', 'icon' => '🔄']] as $value => $opt)
                                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 transition
                                        {{ old('company_role') === $value ? 'border-[#2D6A4F] bg-[#2D6A4F]/5' : 'border-gray-200 hover:border-[#2D6A4F]/50' }}">
                                        <input type="radio" name="company_role" value="{{ $value }}"
                                               {{ old('company_role') === $value ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="flex-1">
                                            <span class="text-lg">{{ $opt['icon'] }}</span>
                                            <p class="text-sm font-semibold text-gray-800 mt-1">{{ $opt['label'] }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $opt['desc'] }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('company_role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-[#2D6A4F] hover:bg-[#245a42] text-white font-semibold py-2.5 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2D6A4F]"
                >
                    Registar empresa
                </button>
            </form>

            {{-- Links --}}
            <div class="mt-6 text-center text-sm text-gray-600">
                <p>
                    Já tem conta?
                    <a href="{{ route('login') }}" class="text-[#C0602A] font-medium hover:underline">Entrar</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
