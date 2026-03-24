<div class="min-h-screen bg-[#F5E6C8]/20">

    {{-- Search & Filter Bar --}}
    <div class="bg-white border-b border-[#F5E6C8] shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">

            {{-- Search Input --}}
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-4">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </span>
                    <input
                        wire:model.live.debounce.400ms="search"
                        type="text"
                        placeholder="Buscar Concurso, fornecimentos, serviços..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-[#F5E6C8] bg-[#F5E6C8]/30
                               focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                               text-gray-800 placeholder-gray-400 transition"
                    />
                </div>

                {{-- Sort --}}
                <div class="shrink-0">
                    <select
                        wire:model.live="sort"
                        class="w-full md:w-auto px-4 py-2.5 rounded-lg border border-[#F5E6C8] bg-white
                               focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                               text-gray-700 transition cursor-pointer"
                    >
                        <option value="latest">Mais Recentes</option>
                        <option value="deadline">Por Prazo</option>
                        <option value="popular">Mais Vistos</option>
                    </select>
                </div>
            </div>

            {{-- Secondary Filters --}}
            <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-5">

                {{-- Category --}}
                <select
                    wire:model.live="category"
                    class="px-3 py-2 rounded-lg border border-[#F5E6C8] bg-white text-sm text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent
                           transition cursor-pointer"
                >
                    <option value="">Todas as Categorias</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                {{-- Contest Type --}}
                <select
                    wire:model.live="contest_type"
                    class="px-3 py-2 rounded-lg border border-[#F5E6C8] bg-white text-sm text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent
                           transition cursor-pointer"
                >
                    <option value="">Tipo de Concurso</option>
                    <option value="public_contest">Concurso Público</option>
                    <option value="tender">Concurso Fechado</option>
                    <option value="project_call">Chamada de Projectos</option>
                    <option value="consulting">Consultoria</option>
                </select>

                {{-- Country --}}
                <input
                    wire:model.live.debounce.400ms="country"
                    type="text"
                    placeholder="País"
                    class="px-3 py-2 rounded-lg border border-[#F5E6C8] bg-white text-sm text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent
                           placeholder-gray-400 transition"
                />

                {{-- City --}}
                <input
                    wire:model.live.debounce.400ms="city"
                    type="text"
                    placeholder="Cidade"
                    class="px-3 py-2 rounded-lg border border-[#F5E6C8] bg-white text-sm text-gray-700
                           focus:outline-none focus:ring-2 focus:ring-[#2D6A4F] focus:border-transparent
                           placeholder-gray-400 transition"
                />

                {{-- Clear Filters --}}
                @if($search || $category || $contest_type || $country || $city)
                    <button
                        wire:click="$set('search', ''); $set('category', ''); $set('contest_type', ''); $set('country', ''); $set('city', '')"
                        class="px-3 py-2 rounded-lg border border-[#C0602A] text-[#C0602A] text-sm font-medium
                               hover:bg-[#C0602A] hover:text-white transition"
                    >
                        Limpar Filtros
                    </button>
                @endif

            </div>
        </div>
    </div>

    {{-- Results --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Result count --}}
        <div class="mb-5 flex items-center justify-between">
            <p class="text-sm text-gray-500">
                <span class="font-semibold text-gray-800">{{ $contests->total() }}</span>
                {{ Str::plural('concurso', $contests->total()) }} encontrado{{ $contests->total() !== 1 ? 's' : '' }}
            </p>

            {{-- Loading indicator --}}
            <div wire:loading class="flex items-center gap-2 text-sm text-[#C0602A]">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Pesquisando...
            </div>
        </div>

        {{-- Grid of Contest Cards --}}
        @if($contests->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($contests as $contest)
                    <article
                        class="group bg-white rounded-xl border border-[#F5E6C8] shadow-sm overflow-hidden
                               hover:shadow-md hover:border-[#D4A017]/60 transition-all duration-200"
                    >
                        {{-- Card Header --}}
                        <div class="px-5 pt-5 pb-4 flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                {{-- Category Badge --}}
                                @if($contest->category)
                                    <span
                                        class="inline-block mb-2 px-2.5 py-0.5 rounded-full text-xs font-semibold
                                               bg-[#2D6A4F]/10 text-[#2D6A4F] border border-[#2D6A4F]/20"
                                    >
                                        {{ $contest->category->name }}
                                    </span>
                                @endif

                                {{-- Title --}}
                                <h3 class="text-base font-bold text-gray-900 leading-snug truncate
                                           group-hover:text-[#C0602A] transition-colors">
                                    {{ $contest->title }}
                                </h3>

                                {{-- Company --}}
                                @if($contest->company)
                                    <p class="mt-1 text-sm text-gray-500 truncate">
                                        {{ $contest->company->name }}
                                    </p>
                                @endif
                            </div>

                            {{-- Save Button --}}
                            @livewire('save-contest', ['contestId' => $contest->id], key('save-'.$contest->id))
                        </div>

                        {{-- Divider --}}
                        <div class="mx-5 border-t border-[#F5E6C8]"></div>

                        {{-- Meta Info --}}
                        <div class="px-5 py-3 space-y-2">

                            {{-- Location --}}
                            @if($contest->city || $contest->country)
                                <div class="flex items-center gap-1.5 text-sm text-gray-500">
                                    <svg class="w-4 h-4 shrink-0 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">
                                        {{ collect([$contest->city, $contest->country])->filter()->implode(', ') }}
                                    </span>
                                </div>
                            @endif

                            {{-- Contest Type --}}
                            @if($contest->contest_type)
                                <div class="flex items-center gap-1.5 text-sm text-gray-500">
                                    <svg class="w-4 h-4 shrink-0 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="capitalize">{{ $contest->contest_type }}</span>
                                </div>
                            @endif

                            {{-- Professional Area --}}
                            @if($contest->professional_area)
                                <div class="flex items-center gap-1.5 text-sm text-gray-500">
                                    <svg class="w-4 h-4 shrink-0 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="truncate">{{ $contest->professional_area }}</span>
                                </div>
                            @endif

                        </div>

                        {{-- Card Footer --}}
                        <div class="px-5 pb-5 flex items-center justify-between gap-2">

                            {{-- Deadline --}}
                            <div class="flex items-center gap-1.5">
                                @if($contest->deadline)
                                    @php
                                        $daysLeft = (int) floor(now()->diffInDays($contest->deadline, false));
                                        $deadlineColor = $daysLeft <= 7
                                            ? 'text-red-600 bg-red-50 border-red-200'
                                            : ($daysLeft <= 30
                                                ? 'text-[#C0602A] bg-orange-50 border-orange-200'
                                                : 'text-[#2D6A4F] bg-[#2D6A4F]/10 border-[#2D6A4F]/20');
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium border {{ $deadlineColor }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $contest->deadline->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>

                            {{-- Views --}}
                            <div class="flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($contest->views_count ?? 0) }}
                            </div>

                        </div>

                        {{-- CTA --}}
                        <div class="px-5 pb-5">
                            <a
                                href="{{ route('contests.show', $contest->slug) }}"
                                class="block w-full text-center px-4 py-2.5 rounded-lg text-sm font-semibold
                                       bg-[#C0602A] text-white hover:bg-[#a8521f] focus:outline-none
                                       focus:ring-2 focus:ring-[#C0602A] focus:ring-offset-2 transition-colors"
                            >
                                Ver Detalhes
                            </a>
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $contests->links() }}
            </div>

        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-20 h-20 rounded-full bg-[#F5E6C8] flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-[#C0602A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Nenhum concurso encontrado</h3>
                <p class="text-gray-500 text-sm max-w-sm">
                    Tente ajustar os filtros ou ampliar os termos de pesquisa.
                </p>
            </div>
        @endif

    </div>
</div>
