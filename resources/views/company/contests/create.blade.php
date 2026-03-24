@extends('layouts.company')

@section('title', 'Publicar Concurso de Fornecimento')
@section('page-title', 'Publicar Concurso de Fornecimento')

@section('content')

<div class="max-w-3xl"
     x-data="{ participationType: '{{ old('participation_type', 'full_application') }}' }">

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            <p class="text-sm font-semibold text-red-700 mb-2">Corrija os seguintes erros:</p>
            <ul class="list-disc list-inside space-y-1 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('company.contests.store') }}" enctype="multipart/form-data"
          class="space-y-6">
        @csrf

        {{-- Section 1: Informações Básicas --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <span class="w-6 h-6 rounded-full bg-[#C0602A] text-white text-xs font-bold flex items-center justify-center flex-shrink-0">1</span>
                <h2 class="text-sm font-bold text-gray-800">Informações Básicas</h2>
            </div>
            <div class="p-6 space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Título do Concurso <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           placeholder="Ex: Fornecimento de Material Informático, Construção de Armazém..."
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A]/30 focus:border-[#C0602A] transition @error('title') border-red-400 @enderror">
                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Categoria <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A]/30 focus:border-[#C0602A] transition @error('category_id') border-red-400 @enderror">
                            <option value="">Seleccionar categoria</option>
                            @foreach ($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Tipo de Concurso <span class="text-red-500">*</span>
                        </label>
                        <select name="contest_type" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A]/30 focus:border-[#C0602A] transition @error('contest_type') border-red-400 @enderror">
                            <option value="">Seleccionar tipo</option>
                            <option value="tender"         {{ old('contest_type') === 'tender'         ? 'selected' : '' }}>Licitação / Concurso Público</option>
                            <option value="consulting"     {{ old('contest_type') === 'consulting'     ? 'selected' : '' }}>Consultoria</option>
                            <option value="project_call"   {{ old('contest_type') === 'project_call'   ? 'selected' : '' }}>Chamada de Propostas</option>
                            <option value="public_contest" {{ old('contest_type') === 'public_contest' ? 'selected' : '' }}>Concurso Restrito</option>
                        </select>
                        @error('contest_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Tipo de Participação <span class="text-red-500">*</span>
                        </label>
                        <select name="participation_type" required
                                x-model="participationType"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C0602A]/30 focus:border-[#C0602A] transition @error('participation_type') border-red-400 @enderror">
                            <option value="full_application"    {{ old('participation_type', 'full_application') === 'full_application'    ? 'selected' : '' }}>Proposta Completa (formulário + documentos)</option>
                            <option value="interest_submission" {{ old('participation_type') === 'interest_submission' ? 'selected' : '' }}>Manifestação de Interesse</option>
                            <option value="info_only"           {{ old('participation_type') === 'info_only'           ? 'selected' : '' }}>Informação Externa (link)</option>
                        </select>
                        @error('participation_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Accepts Proposals toggle --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Submissão de Propostas
                        </label>
                        <label class="flex items-start gap-4 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-[#C0602A]/40 transition"
                               :class="acceptsProposals ? 'border-[#C0602A]/50 bg-[#C0602A]/5' : 'bg-gray-50'"
                               x-data="{ acceptsProposals: {{ old('accepts_proposals', '1') === '1' ? 'true' : 'false' }} }"
                               @click="acceptsProposals = !acceptsProposals">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-10 h-6 rounded-full transition-colors duration-200 relative"
                                     :class="acceptsProposals ? 'bg-[#C0602A]' : 'bg-gray-300'">
                                    <div class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"
                                         :class="acceptsProposals ? 'translate-x-5' : 'translate-x-1'"></div>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800"
                                   x-text="acceptsProposals ? 'Aceitar submissão de propostas' : 'Não aceitar propostas'"></p>
                                <p class="text-xs text-gray-500 mt-0.5"
                                   x-text="acceptsProposals ? 'Fornecedores poderão submeter propostas directamente na plataforma.' : 'O concurso é apenas informativo. Não serão aceites propostas pela plataforma.'"></p>
                            </div>
                            <input type="hidden" name="accepts_proposals" :value="acceptsProposals ? '1' : '0'">
                        </label>
                    </div>
                </div>

            </div>
        </div>

        {{-- Section 2: Localização --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <span class="w-6 h-6 rounded-full bg-[#2D6A4F] text-white text-xs font-bold flex items-center justify-center flex-shrink-0">2</span>
                <h2 class="text-sm font-bold text-gray-800">Localização</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                <x-location-select
                    country-name="country"
                    city-name="city"
                    :country-value="old('country', '')"
                    :city-value="old('city', '')"
                    ring-color="focus:ring-[#2D6A4F]/30"
                    border-focus="focus:border-[#2D6A4F]"
                />

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipo de Localização</label>
                    <select name="location_type"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#2D6A4F]/30 focus:border-[#2D6A4F] transition @error('location_type') border-red-400 @enderror">
                        <option value="local"         {{ old('location_type') === 'local'         ? 'selected' : '' }}>Local</option>
                        <option value="national"      {{ old('location_type') === 'national'      ? 'selected' : '' }}>Nacional</option>
                        <option value="international" {{ old('location_type') === 'international' ? 'selected' : '' }}>Internacional</option>
                        <option value="remote"        {{ old('location_type') === 'remote'        ? 'selected' : '' }}>Remoto</option>
                    </select>
                    @error('location_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Área / Sector</label>
                    <input type="text" name="professional_area" value="{{ old('professional_area') }}"
                           placeholder="Ex: Construção Civil, Fornecimento de Equipamento TI"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#2D6A4F]/30 focus:border-[#2D6A4F] transition @error('professional_area') border-red-400 @enderror">
                    @error('professional_area') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- Section 3: Detalhes --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <span class="w-6 h-6 rounded-full bg-[#D4A017] text-white text-xs font-bold flex items-center justify-center flex-shrink-0">3</span>
                <h2 class="text-sm font-bold text-gray-800">Detalhes</h2>
            </div>
            <div class="p-6 space-y-5">

                {{-- Descrição com Quill --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Descrição <span class="text-red-500">*</span>
                    </label>
                    <div id="editor-description" class="quill-editor rounded-xl border border-gray-200 @error('description') border-red-400 @enderror" style="min-height:180px"></div>
                    <textarea name="description" id="textarea-description" class="hidden" required>{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Requisitos com Quill --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Requisitos <span class="text-gray-400 font-normal text-xs">(opcional)</span></label>
                    <div id="editor-requirements" class="quill-editor rounded-xl border border-gray-200" style="min-height:140px"></div>
                    <textarea name="requirements" id="textarea-requirements" class="hidden">{{ old('requirements') }}</textarea>
                </div>

                {{-- Critérios com Quill --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Critérios de Avaliação <span class="text-gray-400 font-normal text-xs">(opcional)</span></label>
                    <div id="editor-benefits" class="quill-editor rounded-xl border border-gray-200" style="min-height:120px"></div>
                    <textarea name="benefits" id="textarea-benefits" class="hidden">{{ old('benefits') }}</textarea>
                </div>

            </div>
        </div>

        {{-- Section 4: Condições --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <span class="w-6 h-6 rounded-full bg-gray-600 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">4</span>
                <h2 class="text-sm font-bold text-gray-800">Condições</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Data Limite de Submissão <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition @error('deadline') border-red-400 @enderror">
                    @error('deadline') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Moeda</label>
                    <select name="budget_currency"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition">
                        <option value="USD" {{ old('budget_currency') === 'USD' ? 'selected' : '' }}>USD – Dólar Americano</option>
                        <option value="AOA" {{ old('budget_currency') === 'AOA' ? 'selected' : '' }}>AOA – Kwanza Angolano</option>
                        <option value="EUR" {{ old('budget_currency') === 'EUR' ? 'selected' : '' }}>EUR – Euro</option>
                        <option value="MZN" {{ old('budget_currency') === 'MZN' ? 'selected' : '' }}>MZN – Metical Moçambicano</option>
                        <option value="ZAR" {{ old('budget_currency') === 'ZAR' ? 'selected' : '' }}>ZAR – Rand Sul-Africano</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Orçamento Mínimo
                        <span class="text-gray-400 font-normal text-xs">(opcional)</span>
                    </label>
                    <input type="number" name="budget_min" value="{{ old('budget_min') }}" min="0" step="0.01"
                           placeholder="Ex: 50000.00"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition @error('budget_min') border-red-400 @enderror">
                    @error('budget_min') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Orçamento Máximo
                        <span class="text-gray-400 font-normal text-xs">(opcional)</span>
                    </label>
                    <input type="number" name="budget_max" value="{{ old('budget_max') }}" min="0" step="0.01"
                           placeholder="Ex: 100000.00"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition @error('budget_max') border-red-400 @enderror">
                    @error('budget_max') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- External URL: shown only when participation_type = info_only --}}
                <div class="sm:col-span-2" x-show="participationType === 'info_only'" x-transition>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Externo</label>
                    <input type="url" name="external_url" value="{{ old('external_url') }}"
                           placeholder="https://exemplo.com/candidatura"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-400/30 focus:border-gray-400 transition @error('external_url') border-red-400 @enderror">
                    <p class="mt-1 text-xs text-gray-400">Link externo para mais informações ou candidatura.</p>
                    @error('external_url') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- Section 5: Documentos --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <span class="w-6 h-6 rounded-full bg-[#C0602A] bg-opacity-70 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">5</span>
                <h2 class="text-sm font-bold text-gray-800">Documentos</h2>
            </div>
            <div class="p-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Anexar Documentos
                    <span class="text-gray-400 font-normal text-xs">(opcional, múltiplos ficheiros)</span>
                </label>
                <input type="file" name="documents[]" multiple
                       class="block w-full text-sm text-gray-600
                              file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                              file:text-sm file:font-semibold
                              file:bg-[#F5E6C8] file:text-[#C0602A]
                              hover:file:bg-[#C0602A] hover:file:text-white
                              transition">
                <p class="mt-2 text-xs text-gray-400">Formatos aceites: PDF, DOC, DOCX, XLS, XLSX. Máximo 10MB por ficheiro.</p>
                @error('documents')   <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                @error('documents.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('company.contests.index') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit"
                    class="px-8 py-2.5 bg-[#C0602A] text-white rounded-xl text-sm font-semibold hover:bg-[#a8501f] transition shadow-md">
                Publicar Concurso de Fornecimento
            </button>
        </div>

    </form>
</div>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
.quill-editor .ql-container { font-size: 0.875rem; font-family: inherit; border: none; border-radius: 0 0 0.75rem 0.75rem; }
.quill-editor .ql-toolbar { border: none; border-bottom: 1px solid #e5e7eb; border-radius: 0.75rem 0.75rem 0 0; background: #f9fafb; }
.quill-editor { border-radius: 0.75rem; overflow: hidden; }
.quill-editor .ql-editor { min-height: 120px; }
.quill-editor .ql-editor.ql-blank::before { font-style: normal; color: #9ca3af; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
(function () {
    const toolbar = [
        ['bold', 'italic', 'underline'],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'header': [2, 3, false] }],
        ['link', 'clean']
    ];

    function initQuill(editorId, textareaId, placeholder) {
        const textarea = document.getElementById(textareaId);
        const quill = new Quill('#' + editorId, {
            theme: 'snow',
            placeholder: placeholder,
            modules: { toolbar }
        });

        // Pre-fill with existing content
        if (textarea.value.trim()) {
            quill.root.innerHTML = textarea.value;
        }

        // Sync on submit
        textarea.form.addEventListener('submit', function () {
            textarea.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
        });

        return quill;
    }

    document.addEventListener('DOMContentLoaded', function () {
        initQuill('editor-description',  'textarea-description',  'Descreva o concurso: o que pretende adquirir, quantidades, especificações técnicas...');
        initQuill('editor-requirements', 'textarea-requirements', 'Liste os requisitos obrigatórios: licenças, certificações, experiência mínima...');
        initQuill('editor-benefits',     'textarea-benefits',     'Ex: 60% preço, 30% qualidade técnica, 10% prazo de entrega...');
    });
})();
</script>
@endpush
