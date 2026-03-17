@extends('layouts.app')

@section('title', 'Manifestar Interesse — ' . $contest->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    {{-- Contest header --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 rounded-xl bg-[#C0602A] flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                {{ strtoupper(substr($contest->company->name ?? 'G', 0, 1)) }}
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $contest->title }}</h1>
                <p class="text-gray-500 text-sm mt-1">
                    {{ $contest->company->name ?? '—' }} •
                    {{ $contest->city }}, {{ $contest->country }} •
                    Prazo: <strong class="text-[#C0602A]">{{ $contest->deadline ? $contest->deadline->format('d/m/Y') : '—' }}</strong>
                </p>
            </div>
        </div>
    </div>

    {{-- Interest form (Livewire) --}}
    @livewire('interest-form', ['contest' => $contest])
</div>
@endsection
