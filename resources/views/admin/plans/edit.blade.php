@extends('layouts.admin')

@section('title', 'Editar Plano')
@section('page-title', 'Editar Plano')
@section('page-subtitle', 'Actualizar plano: ' . ($plan->name ?? ''))

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-700">Informações do Plano</h2>
        </div>

        <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nome do Plano <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $plan->name) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition
                              @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition resize-none
                                 @error('description') border-red-400 @enderror">{{ old('description', $plan->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Price --}}
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Preço (AOA) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">AOA</span>
                    <input type="number" id="price" name="price" value="{{ old('price', $plan->price) }}" min="0" step="0.01" required
                           class="w-full pl-14 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition
                                  @error('price') border-red-400 @enderror">
                </div>
                @error('price')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Billing Cycle --}}
            <div>
                <label for="billing_cycle" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Ciclo de Facturação <span class="text-red-500">*</span>
                </label>
                <select id="billing_cycle" name="billing_cycle" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition bg-white
                               @error('billing_cycle') border-red-400 @enderror">
                    @php $bc = old('billing_cycle', $plan->billing_cycle); @endphp
                    <option value="monthly"   {{ $bc === 'monthly'   ? 'selected' : '' }}>Mensal</option>
                    <option value="quarterly" {{ $bc === 'quarterly' ? 'selected' : '' }}>Trimestral</option>
                    <option value="annual"    {{ $bc === 'annual'    ? 'selected' : '' }}>Anual</option>
                    <option value="lifetime"  {{ $bc === 'lifetime'  ? 'selected' : '' }}>Vitalício</option>
                </select>
                @error('billing_cycle')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Max Contests --}}
            @php $isUnlimited = old('unlimited_contests', $plan->max_contests === null); @endphp
            <div x-data="{ unlimited: {{ $isUnlimited ? 'true' : 'false' }} }">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Máximo de Concursos</label>
                <div class="flex items-center gap-3 mb-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="unlimited" name="unlimited_contests" value="1"
                               {{ $isUnlimited ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-terracota border-gray-300 focus:ring-terracota/40">
                        <span class="text-sm text-gray-600">Ilimitado</span>
                    </label>
                </div>
                <input type="number" name="max_contests"
                       value="{{ old('max_contests', $plan->max_contests) }}" min="1"
                       x-bind:disabled="unlimited"
                       x-bind:class="unlimited ? 'opacity-40 cursor-not-allowed' : ''"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition
                              @error('max_contests') border-red-400 @enderror">
                @error('max_contests')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Features --}}
            <div>
                <label for="features" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Funcionalidades <span class="text-gray-400 font-normal">(uma por linha)</span>
                </label>
                <textarea id="features" name="features" rows="5"
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition font-mono
                                 @error('features') border-red-400 @enderror">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : $plan->features) }}</textarea>
                @error('features')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Toggles --}}
            <div class="grid grid-cols-2 gap-6">
                @php $isActive = old('is_active', $plan->is_active); @endphp
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative" x-data="{ on: {{ $isActive ? 'true' : 'false' }} }">
                            <input type="hidden" name="is_active" :value="on ? '1' : '0'">
                            <button type="button" @click="on = !on"
                                    :class="on ? 'bg-forest-green' : 'bg-gray-300'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition">
                                <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                      class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition"></span>
                            </button>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Activo</p>
                            <p class="text-xs text-gray-400">Visível para empresas</p>
                        </div>
                    </label>
                </div>
                @php $isFeatured = old('is_featured', $plan->is_featured); @endphp
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative" x-data="{ on: {{ $isFeatured ? 'true' : 'false' }} }">
                            <input type="hidden" name="is_featured" :value="on ? '1' : '0'">
                            <button type="button" @click="on = !on"
                                    :class="on ? 'bg-golden' : 'bg-gray-300'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition">
                                <span :class="on ? 'translate-x-6' : 'translate-x-1'"
                                      class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition"></span>
                            </button>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Destaque</p>
                            <p class="text-xs text-gray-400">Marcado como popular</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="flex items-center gap-2 px-6 py-2.5 bg-terracota text-white text-sm font-semibold rounded-lg hover:bg-terracota/90 transition">
                    Guardar Alterações
                </button>
                <a href="{{ route('admin.plans.index') }}"
                   class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
