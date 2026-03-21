@extends('layouts.admin')

@section('title', 'Categorias')
@section('page-title', 'Categorias')
@section('page-subtitle', 'Gerir categorias de Concurso')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ isset($categories) ? $categories->total() : 0 }} categorias registadas</p>
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-2 px-5 py-2.5 bg-terracota text-white text-sm font-semibold rounded-lg hover:bg-terracota/90 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nova Categoria
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ícone</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cor</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Activa</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories ?? [] as $category)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <span class="text-2xl">{{ $category->icon ?? '📁' }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $category->name }}</td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded font-mono">{{ $category->slug }}</code>
                        </td>
                        <td class="px-6 py-4">
                            @if($category->color)
                                <div class="flex items-center gap-2">
                                    <span class="w-5 h-5 rounded-full border border-gray-200 inline-block flex-shrink-0"
                                          style="background-color: {{ $category->color }}"></span>
                                    <span class="text-xs text-gray-500 font-mono">{{ $category->color }}</span>
                                </div>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold
                                         {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Eliminar esta categoria?')">
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
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">
                            Nenhuma categoria encontrada. <a href="{{ route('admin.categories.create') }}" class="text-terracota hover:underline">Criar a primeira categoria.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($categories) && method_exists($categories, 'hasPages') && $categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    @endif
</div>

@endsection
