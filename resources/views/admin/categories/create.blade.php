@extends('layouts.admin')

@section('title', 'Nova Categoria')
@section('page-title', 'Nova Categoria')
@section('page-subtitle', 'Adicionar uma nova categoria de concursos')

@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-700">Dados da Categoria</h2>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="p-6 space-y-5"
              x-data="categoryForm()">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nome <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       @input="updateSlug($event.target.value)"
                       placeholder="ex: Tecnologia"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition
                              @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Slug <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal">(auto-gerado)</span>
                </label>
                <input type="text" id="slug" name="slug" x-model="slug"
                       value="{{ old('slug') }}" required
                       placeholder="ex: tecnologia"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition
                              @error('slug') border-red-400 @enderror">
                @error('slug')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Icon --}}
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Ícone <span class="text-gray-400 font-normal">(emoji)</span>
                </label>
                <div class="flex items-center gap-3">
                    <span class="text-3xl w-12 h-12 flex items-center justify-center bg-gray-50 rounded-lg border border-gray-200"
                          x-text="iconPreview">{{ old('icon', '📁') }}</span>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', '📁') }}"
                           @input="iconPreview = $event.target.value"
                           x-model="iconPreview"
                           placeholder="Colar emoji aqui..."
                           class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition
                                  @error('icon') border-red-400 @enderror">
                </div>
                @error('icon')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Breve descrição da categoria..."
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition resize-none
                                 @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Color --}}
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1.5">Cor</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="color" name="color" value="{{ old('color', '#C0602A') }}"
                           x-model="colorValue"
                           class="w-12 h-10 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                    <input type="text" x-model="colorValue" @input="syncColor($event.target.value)"
                           placeholder="#C0602A"
                           class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition">
                </div>
                @error('color')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Active --}}
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative" x-data="{ on: {{ old('is_active', true) ? 'true' : 'false' }} }">
                        <input type="hidden" name="is_active" :value="on ? '1' : '0'">
                        <button type="button" @click="on = !on"
                                :class="on ? 'bg-forest-green' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition">
                            <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                  class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition"></span>
                        </button>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Activa</p>
                        <p class="text-xs text-gray-400">Disponível para selecção nos concursos</p>
                    </div>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="flex items-center gap-2 px-6 py-2.5 bg-terracota text-white text-sm font-semibold rounded-lg hover:bg-terracota/90 transition">
                    Criar Categoria
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function categoryForm() {
    return {
        slug: '{{ old('slug') }}',
        iconPreview: '{{ old('icon', '📁') }}',
        colorValue: '{{ old('color', '#C0602A') }}',
        updateSlug(name) {
            this.slug = name
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        },
        syncColor(val) {
            if (/^#[0-9a-fA-F]{6}$/.test(val)) {
                this.colorValue = val;
            }
        }
    }
}
</script>
@endpush
