@extends('layouts.company')

@section('title', 'Editar Concurso')
@section('page-title', 'Editar Concurso')

@section('content')

<div class="max-w-3xl">

    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('company.contests.index') }}"
           class="flex items-center gap-2 text-sm text-gray-500 hover:text-forest-green transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Voltar à lista
        </a>
        <x-badge :type="$contest->status ?? 'draft'" :label="$contest->status_label ?? 'Rascunho'" />
    </div>

    <form method="POST" action="{{ route('company.contests.update', $contest->id) }}" enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Basic info --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <span class="w-1 h-5 bg-terracota rounded-full"></span>
                Informações Básicas
            </h2>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Título *</label>
                <input type="text" name="title" value="{{ old('title', $contest->title) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition @error('title') border-red-400 @enderror">
                @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Categoria *</label>
                    <select name="category_id" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}"
                                    {{ old('category_id', $contest->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-location-select
                    country-name="country"
                    city-name="city"
                    :country-value="old('country', $contest->country ?? '')"
                    :city-value="old('city', $contest->city ?? '')"
                    :required="true"
                />

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Prazo</label>
                    <input type="date" name="deadline"
                           value="{{ old('deadline', isset($contest->deadline) ? \Carbon\Carbon::parse($contest->deadline)->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipo de Concurso *</label>
                    <select name="contest_type" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                        <option value="public_contest" {{ old('contest_type', $contest->contest_type) === 'public_contest' ? 'selected' : '' }}>Concurso Público</option>
                        <option value="tender"         {{ old('contest_type', $contest->contest_type) === 'tender'         ? 'selected' : '' }}>Concurso Fechado (Tender)</option>
                        <option value="project_call"   {{ old('contest_type', $contest->contest_type) === 'project_call'   ? 'selected' : '' }}>Chamada de Projectos</option>
                        <option value="consulting"     {{ old('contest_type', $contest->contest_type) === 'consulting'     ? 'selected' : '' }}>Consultoria</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipo de Participação *</label>
                    <select name="participation_type" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                        <option value="info_only" {{ old('participation_type', $contest->participation_type) === 'info_only' ? 'selected' : '' }}>Apenas Informação</option>
                        <option value="interest_submission" {{ old('participation_type', $contest->participation_type) === 'interest_submission' ? 'selected' : '' }}>Manifestação de Interesse</option>
                        <option value="full_application" {{ old('participation_type', $contest->participation_type) === 'full_application' ? 'selected' : '' }}>Proposta Completa</option>
                    </select>
                </div>

                {{-- Accepts Proposals toggle --}}
                <div class="col-span-full"
                     x-data="{ acceptsProposals: {{ old('accepts_proposals', $contest->accepts_proposals ?? true) ? 'true' : 'false' }} }">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Submissão de Propostas</label>
                    <label class="flex items-start gap-4 p-4 rounded-xl border cursor-pointer hover:border-terracota/40 transition"
                           :class="acceptsProposals ? 'border-terracota/50 bg-terracota/5' : 'border-gray-200 bg-gray-50'"
                           @click="acceptsProposals = !acceptsProposals">
                        <div class="flex-shrink-0 mt-0.5">
                            <div class="w-10 h-6 rounded-full transition-colors duration-200 relative"
                                 :class="acceptsProposals ? 'bg-terracota' : 'bg-gray-300'">
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

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estado</label>
                    <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                        <option value="draft"  {{ old('status', $contest->status) === 'draft'  ? 'selected' : '' }}>Rascunho</option>
                        <option value="active" {{ old('status', $contest->status) === 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="closed" {{ old('status', $contest->status) === 'closed' ? 'selected' : '' }}>Fechado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Externa</label>
                    <input type="url" name="external_url" value="{{ old('external_url', $contest->external_url ?? '') }}"
                           placeholder="https://..."
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <span class="w-1 h-5 bg-golden rounded-full"></span>
                Conteúdo
            </h2>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Descrição <span class="text-red-500">*</span></label>
                <div id="editor-description" class="quill-editor rounded-xl border border-gray-200 @error('description') border-red-400 @enderror" style="min-height:160px"></div>
                <textarea name="description" id="textarea-description" class="hidden">{{ old('description', $contest->description) }}</textarea>
                @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Requisitos <span class="text-gray-400 font-normal text-xs">(opcional)</span></label>
                <div id="editor-requirements" class="quill-editor rounded-xl border border-gray-200" style="min-height:120px"></div>
                <textarea name="requirements" id="textarea-requirements" class="hidden">{{ old('requirements', $contest->requirements ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Critérios de Avaliação <span class="text-gray-400 font-normal text-xs">(opcional)</span></label>
                <div id="editor-benefits" class="quill-editor rounded-xl border border-gray-200" style="min-height:100px"></div>
                <textarea name="benefits" id="textarea-benefits" class="hidden">{{ old('benefits', $contest->benefits ?? '') }}</textarea>
            </div>
        </div>

        {{-- Budget --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <span class="w-1 h-5 bg-terracota rounded-full"></span>
                Orçamento Estimado
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Valor Mínimo</label>
                    <input type="number" name="budget_min" min="0" step="0.01"
                           value="{{ old('budget_min', $contest->budget_min ?? '') }}"
                           placeholder="0.00"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Valor Máximo</label>
                    <input type="number" name="budget_max" min="0" step="0.01"
                           value="{{ old('budget_max', $contest->budget_max ?? '') }}"
                           placeholder="0.00"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Moeda</label>
                    <select name="budget_currency"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                        @foreach(['USD','AOA','EUR','GBP','ZAR','BRL'] as $cur)
                            <option value="{{ $cur }}" {{ old('budget_currency', $contest->budget_currency ?? 'USD') === $cur ? 'selected' : '' }}>{{ $cur }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('company.contests.index') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit"
                    class="px-8 py-2.5 bg-forest-green text-white rounded-xl text-sm font-semibold hover:bg-green-800 transition shadow-md">
                Guardar Alterações
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

    function initQuill(editorId, textareaId, placeholder, required) {
        const textarea = document.getElementById(textareaId);
        const wrapper  = document.getElementById(editorId);
        const quill = new Quill('#' + editorId, {
            theme: 'snow',
            placeholder: placeholder,
            modules: { toolbar }
        });

        if (textarea.value.trim()) {
            quill.root.innerHTML = textarea.value;
        }

        textarea.form.addEventListener('submit', function (e) {
            const html = quill.root.innerHTML;
            const empty = html === '<p><br></p>' || html.trim() === '';
            textarea.value = empty ? '' : html;

            if (required && empty) {
                e.preventDefault();
                wrapper.style.borderColor = '#f87171';
                quill.root.focus();
            } else {
                wrapper.style.borderColor = '';
            }
        });

        return quill;
    }

    document.addEventListener('DOMContentLoaded', function () {
        initQuill('editor-description',  'textarea-description',  'Descreva o concurso...', true);
        initQuill('editor-requirements', 'textarea-requirements', 'Liste os requisitos obrigatórios...', false);
        initQuill('editor-benefits',     'textarea-benefits',     'Ex: 60% preço, 30% qualidade técnica...', false);
    });
})();
</script>
@endpush
