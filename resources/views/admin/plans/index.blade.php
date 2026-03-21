@extends('layouts.admin')

@section('title', 'Planos')
@section('page-title', 'Planos de Subscrição')
@section('page-subtitle', 'Gerir planos disponíveis para empresas')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ isset($plans) ? $plans->total() : 0 }} planos registados</p>
    <a href="{{ route('admin.plans.create') }}"
       class="flex items-center gap-2 px-5 py-2.5 bg-terracota text-white text-sm font-semibold rounded-lg hover:bg-terracota/90 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Novo Plano
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Preço</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Facturação</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Máx. Concurso</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Destaque</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Activo</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($plans ?? [] as $plan)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800">{{ $plan->name }}</span>
                                @if($plan->is_featured)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-golden/20 text-yellow-700">
                                        Popular
                                    </span>
                                @endif
                            </div>
                            @if($plan->description)
                                <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $plan->description }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ number_format($plan->price, 2) }} AOA
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $plan->billing_cycle === 'monthly' ? 'Mensal' : ($plan->billing_cycle === 'annual' ? 'Anual' : ucfirst($plan->billing_cycle ?? '—')) }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $plan->max_contests === null ? 'Ilimitado' : $plan->max_contests }}
                        </td>
                        <td class="px-6 py-4">
                            @if($plan->is_featured)
                                <svg class="w-5 h-5 text-golden" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold
                                         {{ $plan->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $plan->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.plans.edit', $plan) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}"
                                      onsubmit="return confirm('Eliminar este plano?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">
                            Nenhum plano encontrado. <a href="{{ route('admin.plans.create') }}" class="text-terracota hover:underline">Criar o primeiro plano.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($plans) && method_exists($plans, 'hasPages') && $plans->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $plans->links() }}
        </div>
    @endif
</div>

@endsection
