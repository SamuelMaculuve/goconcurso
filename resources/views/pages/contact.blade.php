@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<div class="bg-[#F5E6C8] py-14">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Entre em Contacto</h1>
        <p class="text-gray-600">Tem alguma questao, sugestao ou parceria em mente? Fale connosco.</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-12">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow p-8">

                @if(session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700 flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome completo *</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('name') border-red-400 @enderror"
                                placeholder="O seu nome" />
                            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('email') border-red-400 @enderror"
                                placeholder="o.seu@email.com" />
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto *</label>
                        <input id="subject" type="text" name="subject" value="{{ old('subject') }}" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('subject') border-red-400 @enderror"
                            placeholder="ex: Questao sobre candidatura, parceria comercial..." />
                        @error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensagem *</label>
                        <textarea id="message" name="message" rows="6" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition resize-none @error('message') border-red-400 @enderror"
                            placeholder="Descreva o motivo do seu contacto...">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#C0602A] hover:bg-[#a8521f] text-white font-semibold py-3 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C0602A]">
                        Enviar mensagem
                    </button>
                </form>
            </div>
        </div>

        {{-- Contact info sidebar --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-5">Informacoes de contacto</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-[#F5E6C8] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</p>
                            <a href="mailto:info@goconcursos.ao" class="text-sm text-[#C0602A] hover:underline">
                                info@goconcursos.ao
                            </a>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-[#F5E6C8] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Telefone</p>
                            <p class="text-sm text-gray-700">+244 9XX XXX XXX</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-[#F5E6C8] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Localizacao</p>
                            <p class="text-sm text-gray-700">Luanda, Angola</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#2D6A4F] rounded-2xl p-6 text-white">
                <h3 class="font-semibold mb-2">Horario de atendimento</h3>
                <p class="text-sm text-green-200 mb-1">Segunda a Sexta</p>
                <p class="text-sm font-medium">08:00 — 17:00</p>
                <p class="text-xs text-green-300 mt-3">Respondemos normalmente dentro de 24 horas uteis.</p>
            </div>
        </div>
    </div>
</div>
@endsection
