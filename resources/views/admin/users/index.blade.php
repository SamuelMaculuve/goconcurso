@extends('layouts.admin')

@section('title', 'Utilizadores')
@section('page-title', 'Utilizadores')
@section('page-subtitle', 'Gestão de utilizadores da plataforma')

@section('content')

{{-- Search & Filters --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3">
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
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Pesquisar
        </button>
        @if(request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-1 px-4 py-2.5 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200 transition">
                Limpar
            </a>
        @endif
    </form>
</div>

{{-- Role Filter Tabs --}}
<div class="flex gap-2 mb-5 flex-wrap">
    @php
        $roles = ['' => 'Todos', 'admin' => 'Administradores', 'company' => 'Empresas', 'user' => 'Utilizadores'];
    @endphp
    @foreach($roles as $value => $label)
        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => $value])) }}"
           class="px-4 py-2 rounded-full text-sm font-medium transition
                  {{ request('role', '') === $value
                     ? 'bg-terracota text-white'
                     : 'bg-white text-gray-600 border border-gray-200 hover:border-terracota hover:text-terracota' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">E-mail</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Papel</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Criado em</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acções</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users ?? [] as $user)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-terracota flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @php
                                $roleMap = [
                                    'admin'   => 'bg-purple-100 text-purple-700',
                                    'company' => 'bg-golden/20 text-yellow-700',
                                    'user'    => 'bg-blue-100 text-blue-600',
                                ];
                                $roleLabels = ['admin' => 'Admin', 'company' => 'Empresa', 'user' => 'Utilizador'];
                                $roleClass = $roleMap[$user->role] ?? 'bg-gray-100 text-gray-500';
                                $roleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);
                            @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $roleClass }}">
                                {{ $roleLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="relative inline-flex h-5 w-9 items-center rounded-full transition
                                               {{ $user->is_active ? 'bg-forest-green' : 'bg-gray-300' }}"
                                        title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                    <span class="inline-block h-3.5 w-3.5 transform rounded-full bg-white shadow transition
                                                 {{ $user->is_active ? 'translate-x-4' : 'translate-x-1' }}"></span>
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Tem a certeza que deseja eliminar este utilizador?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">
                            Nenhum utilizador encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($users) && $users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
