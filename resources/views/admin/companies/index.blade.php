@extends('layouts.admin')

@section('title', 'Empresas')
@section('page-title', 'Empresas')
@section('page-subtitle', 'Gestão de empresas registadas')

@section('content')

{{-- Search --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" action="{{ route('admin.companies.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Pesquisar por nome ou e-mail..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terracota/40 focus:border-terracota transition">
        </div>
        <button type="submit"
                class="flex items-center gap-2 px-5 py-2.5 bg-terracota text-white text-sm font-semibold rounded-lg hover:bg-terracota/90 transition">
            Pesquisar
        </button>
        @if(request('search'))
            <a href="{{ route('admin.companies.index') }}"
               class="flex items-center px-4 py-2.5 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200 transition">
                Limpar
            </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Logo</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">E-mail</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">País</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Plano</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Verificada</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($companies ?? [] as $company)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            @if($company->logo)
                                <img src="{{ Storage::url($company->logo) }}"
                                     alt="{{ $company->name }}"
                                     class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-golden/20 flex items-center justify-center text-golden font-bold text-sm">
                                    {{ strtoupper(substr($company->name, 0, 2)) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $company->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $company->email }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $company->country ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-golden/15 text-yellow-700">
                                {{ $company->plan->name ?? 'Gratuito' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($company->is_verified)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Verificada
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">
                                    Pendente
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if(!$company->is_verified)
                                    <form method="POST" action="{{ route('admin.companies.verify', $company) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-forest-green text-white hover:bg-green-800 transition">
                                            Verificar
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.companies.show', $company) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                    Ver
                                </a>
                                <form method="POST" action="{{ route('admin.companies.destroy', $company) }}"
                                      onsubmit="return confirm('Tem a certeza que deseja eliminar esta empresa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">
                            Nenhuma empresa encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($companies) && $companies->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $companies->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
