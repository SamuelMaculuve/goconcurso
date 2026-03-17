<div class="max-w-2xl mx-auto">

    @if($submitted)
        {{-- Success State --}}
        <div class="rounded-xl bg-[#2D6A4F]/10 border border-[#2D6A4F]/30 p-8 text-center">
            <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#2D6A4F]/20 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#2D6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#2D6A4F] mb-2">Interesse Registado!</h3>
            <p class="text-gray-600 text-sm">
                O seu interesse no concurso <strong>{{ $contest->title }}</strong> foi registado com sucesso.
                Entraremos em contacto em breve.
            </p>
        </div>

    @else
        {{-- Interest Form --}}
        <form wire:submit="submit" class="space-y-5" enctype="multipart/form-data">

            {{-- Form Header --}}
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Manifestar Interesse</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Preencha os seus dados para manifestar interesse em
                    <span class="font-medium text-[#C0602A]">{{ $contest->title }}</span>.
                </p>
            </div>

            {{-- Name --}}
            <div>
                <label for="interest-name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome Completo <span class="text-red-500">*</span>
                </label>
                <input
                    wire:model="name"
                    id="interest-name"
                    type="text"
                    autocomplete="name"
                    placeholder="O seu nome completo"
                    class="w-full px-4 py-2.5 rounded-lg border
                           @error('name') border-red-400 bg-red-50 @else border-[#F5E6C8] bg-white @enderror
                           focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                           text-gray-800 placeholder-gray-400 transition"
                />
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="interest-email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email <span class="text-red-500">*</span>
                </label>
                <input
                    wire:model="email"
                    id="interest-email"
                    type="email"
                    autocomplete="email"
                    placeholder="nome@exemplo.com"
                    class="w-full px-4 py-2.5 rounded-lg border
                           @error('email') border-red-400 bg-red-50 @else border-[#F5E6C8] bg-white @enderror
                           focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                           text-gray-800 placeholder-gray-400 transition"
                />
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="interest-phone" class="block text-sm font-medium text-gray-700 mb-1">
                    Telefone <span class="text-red-500">*</span>
                </label>
                <input
                    wire:model="phone"
                    id="interest-phone"
                    type="tel"
                    autocomplete="tel"
                    placeholder="+244 900 000 000"
                    class="w-full px-4 py-2.5 rounded-lg border
                           @error('phone') border-red-400 bg-red-50 @else border-[#F5E6C8] bg-white @enderror
                           focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                           text-gray-800 placeholder-gray-400 transition"
                />
                @error('phone')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Professional Area --}}
            <div>
                <label for="interest-area" class="block text-sm font-medium text-gray-700 mb-1">
                    Área Profissional <span class="text-red-500">*</span>
                </label>
                <input
                    wire:model="professional_area"
                    id="interest-area"
                    type="text"
                    placeholder="Ex: Engenharia Civil, Contabilidade..."
                    class="w-full px-4 py-2.5 rounded-lg border
                           @error('professional_area') border-red-400 bg-red-50 @else border-[#F5E6C8] bg-white @enderror
                           focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                           text-gray-800 placeholder-gray-400 transition"
                />
                @error('professional_area')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Message --}}
            <div>
                <label for="interest-message" class="block text-sm font-medium text-gray-700 mb-1">
                    Mensagem
                    <span class="text-gray-400 font-normal">(opcional)</span>
                </label>
                <textarea
                    wire:model="message"
                    id="interest-message"
                    rows="4"
                    placeholder="Descreva brevemente a sua motivação ou experiência relevante..."
                    class="w-full px-4 py-2.5 rounded-lg border
                           @error('message') border-red-400 bg-red-50 @else border-[#F5E6C8] bg-white @enderror
                           focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                           text-gray-800 placeholder-gray-400 transition resize-none"
                ></textarea>
                <p class="mt-1 text-xs text-gray-400 text-right">
                    <span x-data x-text="{{ strlen($message ?? '') }}">{{ strlen($message ?? '') }}</span>/1000
                </p>
                @error('message')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Document Upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Documento de Apresentação
                    <span class="text-gray-400 font-normal">(opcional &mdash; PDF, DOC, DOCX &bull; máx. 5MB)</span>
                </label>
                <div
                    class="relative flex items-center justify-center w-full px-4 py-6 rounded-lg border-2 border-dashed
                           @error('cv') border-red-400 bg-red-50 @else border-[#D4A017]/50 bg-[#F5E6C8]/30 @enderror
                           hover:border-[#D4A017] hover:bg-[#F5E6C8]/50 transition cursor-pointer"
                >
                    <label for="interest-cv" class="flex flex-col items-center gap-2 cursor-pointer w-full">
                        <svg class="w-8 h-8 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        @if($cv)
                            <span class="text-sm font-medium text-[#2D6A4F]">{{ $cv->getClientOriginalName() }}</span>
                        @else
                            <span class="text-sm text-gray-500">
                                Clique para selecionar ou arraste o ficheiro
                            </span>
                        @endif
                        <input
                            wire:model="cv"
                            id="interest-cv"
                            type="file"
                            accept=".pdf,.doc,.docx"
                            class="sr-only"
                        />
                    </label>
                </div>
                <div wire:loading wire:target="cv" class="mt-1 text-xs text-[#C0602A] flex items-center gap-1">
                    <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    A carregar ficheiro...
                </div>
                @error('cv')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-lg
                           bg-[#C0602A] text-white font-semibold text-sm
                           hover:bg-[#a8521f] focus:outline-none focus:ring-2
                           focus:ring-[#C0602A] focus:ring-offset-2 transition
                           disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="submit">Manifestar Interesse</span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        A enviar...
                    </span>
                </button>
            </div>

        </form>
    @endif

</div>
