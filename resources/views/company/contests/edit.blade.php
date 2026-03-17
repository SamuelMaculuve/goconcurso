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

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Localização *</label>
                    <input type="text" name="location" value="{{ old('location', $contest->location) }}" required
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition">
                </div>

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
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Descrição *</label>
                <textarea name="description" rows="6" required
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition resize-none @error('description') border-red-400 @enderror">{{ old('description', $contest->description) }}</textarea>
                @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Requisitos</label>
                <textarea name="requirements" rows="5"
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition resize-none">{{ old('requirements', $contest->requirements ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Critérios de Avaliação</label>
                <textarea name="benefits" rows="4"
                          placeholder="Ex: Experiência comprovada, certificações relevantes, relação qualidade-preço..."
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-terracota/30 focus:border-terracota transition resize-none">{{ old('benefits', $contest->benefits ?? '') }}</textarea>
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
