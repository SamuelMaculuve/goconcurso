@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Editar Perfil</h1>
    </div>

    {{-- Success message --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

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

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Avatar section --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-700 mb-5">Fotografia de perfil</h2>

            <div class="flex flex-col sm:flex-row items-center gap-6">
                {{-- Circular preview --}}
                <div class="flex-shrink-0 relative">
                    @if ($user->avatar)
                        <img id="avatar-preview"
                            src="{{ asset('storage/' . $user->avatar) }}"
                            alt="Avatar"
                            class="w-28 h-28 rounded-full object-cover ring-4 ring-[#F5E6C8]" />
                    @else
                        <div id="avatar-placeholder"
                            class="w-28 h-28 rounded-full bg-[#C0602A] flex items-center justify-center ring-4 ring-[#F5E6C8]">
                            <span class="text-4xl font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        <img id="avatar-preview" src="" alt="Avatar"
                            class="w-28 h-28 rounded-full object-cover ring-4 ring-[#F5E6C8] hidden" />
                    @endif
                </div>

                {{-- Upload button --}}
                <div class="flex-1 text-center sm:text-left">
                    <label
                        for="avatar"
                        class="inline-flex items-center gap-2 cursor-pointer border border-gray-300 text-gray-700 hover:border-[#C0602A] hover:text-[#C0602A] text-sm font-medium px-4 py-2 rounded-lg transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Carregar foto
                    </label>
                    <input id="avatar" type="file" name="avatar" accept="image/*" class="hidden"
                        onchange="previewAvatar(event)" />
                    <p class="mt-2 text-xs text-gray-400">JPG, PNG ou GIF. Max. 2MB. Imagem quadrada recomendada.</p>
                    @error('avatar')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Personal info --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-700 mb-5">Informacoes pessoais</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Name --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('name') border-red-400 @enderror"
                        placeholder="O seu nome completo" />
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('email') border-red-400 @enderror"
                        placeholder="o.seu@email.com" />
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('phone') border-red-400 @enderror"
                        placeholder="+244 900 000 000" />
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <x-location-select
                    country-name="country"
                    city-name="city"
                    :country-value="old('country', $user->country ?? '')"
                    :city-value="old('city', $user->city ?? '')"
                />

                {{-- Professional area --}}
                <div class="md:col-span-2">
                    <label for="professional_area" class="block text-sm font-medium text-gray-700 mb-1">Area profissional</label>
                    <input id="professional_area" type="text" name="professional_area"
                        value="{{ old('professional_area', $user->professional_area ?? '') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition @error('professional_area') border-red-400 @enderror"
                        placeholder="ex: Engenharia de Software, Medicina" />
                    @error('professional_area')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Bio --}}
                <div class="md:col-span-2">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Biografia</label>
                    <textarea id="bio" name="bio" rows="4"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent transition resize-none @error('bio') border-red-400 @enderror"
                        placeholder="Fale um pouco sobre si, as suas competencias e experiencias...">{{ old('bio', $user->bio ?? '') }}</textarea>
                    @error('bio')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- CV Upload --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-700 mb-5">Curriculum Vitae</h2>

            @if ($user->cv_path)
                <div class="flex items-center justify-between mb-4 p-3 bg-[#F5E6C8] rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm text-gray-700">CV actual carregado</span>
                    </div>
                    <a href="{{ asset('storage/' . $user->cv_path) }}" target="_blank"
                        class="text-xs text-[#C0602A] hover:underline">Ver</a>
                </div>
            @endif

            <label for="cv"
                class="flex items-center justify-center gap-2 cursor-pointer border border-dashed border-gray-300 hover:border-[#C0602A] text-gray-600 hover:text-[#C0602A] text-sm px-4 py-4 rounded-lg w-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                {{ $user->cv_path ? 'Substituir CV' : 'Carregar CV' }}
            </label>
            <input id="cv" type="file" name="cv" accept=".pdf,.doc,.docx" class="hidden" />
            <p class="mt-2 text-xs text-gray-400 text-center">PDF, DOC ou DOCX. Max. 5MB.</p>
            @error('cv')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        {{-- Save --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('profile.show') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-600 text-sm font-medium hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-[#C0602A] hover:bg-[#a8521f] text-white text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C0602A]">
                Guardar alteracoes
            </button>
        </div>
    </form>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('avatar-preview');
        const placeholder = document.getElementById('avatar-placeholder');
        if (preview) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
