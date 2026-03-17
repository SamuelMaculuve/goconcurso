<div>
    <button
        wire:click="toggle"
        wire:loading.attr="disabled"
        wire:target="toggle"
        title="{{ $saved ? 'Remover dos guardados' : 'Guardar concurso' }}"
        class="group relative inline-flex items-center justify-center w-9 h-9 rounded-full
               border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2
               {{ $saved
                   ? 'border-[#D4A017] bg-[#D4A017]/10 text-[#D4A017] hover:bg-red-50 hover:border-red-400 hover:text-red-500 focus:ring-[#D4A017]'
                   : 'border-gray-200 bg-white text-gray-400 hover:border-[#D4A017] hover:text-[#D4A017] hover:bg-[#D4A017]/10 focus:ring-[#D4A017]'
               }}
               disabled:opacity-50 disabled:cursor-not-allowed"
        aria-label="{{ $saved ? 'Remover dos guardados' : 'Guardar concurso' }}"
        aria-pressed="{{ $saved ? 'true' : 'false' }}"
    >
        {{-- Loading Spinner --}}
        <span wire:loading wire:target="toggle" class="absolute inset-0 flex items-center justify-center">
            <svg class="animate-spin h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
        </span>

        {{-- Bookmark Icon --}}
        <span wire:loading.remove wire:target="toggle">
            @if($saved)
                {{-- Filled bookmark (saved) --}}
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 3a2 2 0 00-2 2v16l7-3 7 3V5a2 2 0 00-2-2H5z"/>
                </svg>
            @else
                {{-- Outline bookmark (not saved) --}}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3-7 3V5z"/>
                </svg>
            @endif
        </span>

        {{-- Tooltip --}}
        <span
            class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 whitespace-nowrap
                   px-2 py-1 rounded text-xs font-medium text-white bg-gray-800
                   opacity-0 group-hover:opacity-100 transition-opacity duration-150"
        >
            {{ $saved ? 'Remover' : 'Guardar' }}
        </span>
    </button>
</div>
