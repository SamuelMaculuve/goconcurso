@props([
    'type'    => 'success',
    'message' => '',
])

@php
    $styles = [
        'success' => [
            'bg'     => 'bg-green-50 border-green-200',
            'text'   => 'text-green-800',
            'icon'   => 'text-green-400',
            'path'   => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'error' => [
            'bg'     => 'bg-red-50 border-red-200',
            'text'   => 'text-red-800',
            'icon'   => 'text-red-400',
            'path'   => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'warning' => [
            'bg'     => 'bg-yellow-50 border-yellow-200',
            'text'   => 'text-yellow-800',
            'icon'   => 'text-yellow-400',
            'path'   => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        ],
        'info' => [
            'bg'     => 'bg-blue-50 border-blue-200',
            'text'   => 'text-blue-800',
            'icon'   => 'text-blue-400',
            'path'   => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    ];
    $s = $styles[$type] ?? $styles['info'];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition
     class="flex items-start gap-3 border rounded-xl p-4 {{ $s['bg'] }} {{ $s['text'] }} mb-4">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 {{ $s['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['path'] }}"/>
    </svg>
    <div class="flex-1 text-sm leading-relaxed">
        {{ $message }}
        {{ $slot }}
    </div>
    <button @click="show = false" class="flex-shrink-0 {{ $s['icon'] }} hover:opacity-70 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
