<div class="max-w-2xl mx-auto">

    @if($submitted)
        {{-- Success State --}}
        <div class="rounded-xl bg-[#2D6A4F]/10 border border-[#2D6A4F]/30 p-8 text-center">
            <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#2D6A4F]/20 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#2D6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#2D6A4F] mb-2">Proposta Submetida!</h3>
            <p class="text-gray-600 text-sm mb-6">
                A sua proposta para <strong>{{ $contest->title }}</strong> foi enviada com sucesso.
                Será notificado sobre o estado da avaliação.
            </p>
            <a href="{{ route('contests.show', $contest->slug) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#2D6A4F] text-white
                      text-sm font-semibold hover:bg-[#245a42] transition">
                Voltar ao Concurso
            </a>
        </div>

    @else
        {{-- Proposal Form --}}
        <form wire:submit="submit" class="space-y-6">

            {{-- Form Header --}}
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Submeter Proposta</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Apresente a sua proposta para
                    <span class="font-medium text-[#C0602A]">{{ $contest->title }}</span>.
                </p>
            </div>

            {{-- Solution Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descrição da Solução Proposta
                    <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal">(mín. 50 caracteres)</span>
                </label>
                <textarea
                    wire:model="solution_description"
                    rows="7"
                    placeholder="Descreva detalhadamente a solução que propõe, incluindo abordagem técnica, prazo de execução, metodologia e diferenciais da sua empresa..."
                    class="w-full px-4 py-3 rounded-lg border
                           @error('solution_description') border-red-400 bg-red-50 @else border-[#F5E6C8] bg-white @enderror
                           focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                           text-gray-800 placeholder-gray-400 transition resize-none"
                ></textarea>
                <div class="flex justify-between mt-1">
                    <div>@error('solution_description')<p class="text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <p class="text-xs text-gray-400">{{ strlen($solution_description ?? '') }}/5000</p>
                </div>
            </div>

            {{-- Proposed Value --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Valor Proposto
                        <span class="text-gray-400 font-normal">(opcional)</span>
                    </label>
                    <input
                        wire:model="proposed_value"
                        type="number"
                        min="0"
                        step="0.01"
                        placeholder="Ex: 50000.00"
                        class="w-full px-4 py-3 rounded-lg border
                               @error('proposed_value') border-red-400 bg-red-50 @else border-[#F5E6C8] bg-white @enderror
                               focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                               text-gray-800 transition"
                    />
                    @error('proposed_value')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Moeda</label>
                    <select wire:model="currency"
                            class="w-full px-4 py-3 rounded-lg border border-[#F5E6C8] bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#C0602A] focus:border-transparent
                                   text-gray-800 transition">
                        <option value="USD">USD</option>
                        <option value="AOA">AOA</option>
                        <option value="EUR">EUR</option>
                        <option value="MZN">MZN</option>
                        <option value="ZAR">ZAR</option>
                    </select>
                </div>
            </div>

            @if($contest->budget_min || $contest->budget_max)
                <p class="text-xs text-[#2D6A4F] bg-[#2D6A4F]/10 px-3 py-2 rounded-lg">
                    Orçamento estimado pelo contratante:
                    @if($contest->budget_min)
                        {{ number_format($contest->budget_min, 2) }}
                    @endif
                    @if($contest->budget_min && $contest->budget_max) – @endif
                    @if($contest->budget_max)
                        {{ number_format($contest->budget_max, 2) }} {{ $contest->budget_currency }}
                    @endif
                </p>
            @endif

            {{-- Technical Document --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Proposta Técnica / Documento Principal
                    <span class="text-gray-400 font-normal">(opcional — PDF, DOC, DOCX · máx. 10MB)</span>
                </label>
                <div class="flex items-center justify-center w-full px-4 py-6 rounded-lg border-2 border-dashed
                            @error('technical_doc') border-red-400 bg-red-50 @else border-[#D4A017]/50 bg-[#F5E6C8]/30 @enderror
                            hover:border-[#D4A017] hover:bg-[#F5E6C8]/50 transition">
                    <label for="app-technical-doc" class="flex flex-col items-center gap-2 cursor-pointer w-full">
                        <svg class="w-8 h-8 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        @if($technical_doc)
                            <span class="text-sm font-medium text-[#2D6A4F]">{{ $technical_doc->getClientOriginalName() }}</span>
                            <span class="text-xs text-gray-400">Clique para substituir</span>
                        @else
                            <span class="text-sm text-gray-500">Clique para anexar a proposta técnica</span>
                            <span class="text-xs text-gray-400">PDF, DOC ou DOCX</span>
                        @endif
                        <input wire:model="technical_doc" id="app-technical-doc" type="file"
                               accept=".pdf,.doc,.docx" class="sr-only"/>
                    </label>
                </div>
                <div wire:loading wire:target="technical_doc" class="mt-1 text-xs text-[#C0602A] flex items-center gap-1">
                    <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    A carregar...
                </div>
                @error('technical_doc')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Additional Documents --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Documentos Adicionais
                    <span class="text-gray-400 font-normal">(opcional — licenças, certidões, portfólio)</span>
                </label>
                <div class="flex items-center justify-center w-full px-4 py-6 rounded-lg border-2 border-dashed
                            border-[#2D6A4F]/30 bg-[#2D6A4F]/5 hover:border-[#2D6A4F]/60 hover:bg-[#2D6A4F]/10 transition">
                    <label for="app-documents" class="flex flex-col items-center gap-2 cursor-pointer w-full">
                        <svg class="w-8 h-8 text-[#2D6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <span class="text-sm text-gray-500">Seleccionar múltiplos documentos</span>
                        <input wire:model="documents" id="app-documents" type="file" multiple class="sr-only"/>
                    </label>
                </div>
                @if(count($documents) > 0)
                    <ul class="mt-3 space-y-2">
                        @foreach($documents as $doc)
                            <li class="flex items-center gap-3 px-3 py-2 rounded-lg bg-[#F5E6C8]/50 border border-[#F5E6C8]">
                                <svg class="w-4 h-4 shrink-0 text-[#D4A017]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm text-gray-700 truncate flex-1">{{ $doc->getClientOriginalName() }}</span>
                                <span class="text-xs text-gray-400 shrink-0">{{ number_format($doc->getSize() / 1024, 0) }} KB</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Notice --}}
            <div class="rounded-lg bg-[#F5E6C8]/60 border border-[#D4A017]/30 px-4 py-3">
                <p class="text-xs text-gray-600 leading-relaxed">
                    Ao submeter esta proposta, confirma que os dados e documentos fornecidos são verdadeiros e autoriza
                    a <strong>GoConcursos</strong> a partilhá-los com a entidade contratante.
                </p>
            </div>

            {{-- Submit --}}
            <div class="pt-1">
                <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-lg
                               bg-[#C0602A] text-white font-semibold text-sm
                               hover:bg-[#a8521f] focus:outline-none focus:ring-2
                               focus:ring-[#C0602A] focus:ring-offset-2 transition
                               disabled:opacity-60 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="submit">Submeter Proposta</span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        A submeter proposta...
                    </span>
                </button>
            </div>

        </form>
    @endif

</div>
