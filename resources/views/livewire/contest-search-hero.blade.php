<form wire:submit.prevent="submit" class="flex items-center bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="flex-1 flex items-center px-4 gap-2">
        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
        </svg>
        <input
            wire:model.defer="search"
            type="text"
            placeholder="Pesquisar concursos, vagas, bolsas..."
            class="w-full py-4 text-gray-800 placeholder-gray-400 focus:outline-none text-sm sm:text-base"
        />
    </div>
    <button type="submit"
            class="bg-[#C0602A] hover:bg-[#a0501f] text-white font-semibold px-6 py-4 transition-colors text-sm sm:text-base whitespace-nowrap">
        Pesquisar
    </button>
</form>
