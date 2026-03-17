@props([
    'type'  => 'default',
    'label' => '',
])

@php
    $map = [
        // Category slugs
        'tecnologia'    => 'bg-blue-100 text-blue-700',
        'saude'         => 'bg-red-100 text-red-700',
        'educacao'      => 'bg-yellow-100 text-yellow-800',
        'financas'      => 'bg-green-100 text-green-700',
        'engenharia'    => 'bg-gray-200 text-gray-700',
        'direito'       => 'bg-purple-100 text-purple-700',
        'marketing'     => 'bg-pink-100 text-pink-700',
        'logistica'     => 'bg-orange-100 text-orange-700',
        'agricultura'   => 'bg-lime-100 text-lime-700',
        'construcao'    => 'bg-amber-100 text-amber-800',
        'turismo'       => 'bg-sky-100 text-sky-700',
        // Status
        'active'        => 'bg-green-100 text-green-700',
        'open'          => 'bg-green-100 text-green-700',
        'closed'        => 'bg-gray-100 text-gray-500',
        'pending'       => 'bg-yellow-100 text-yellow-700',
        'approved'      => 'bg-green-100 text-green-700',
        'rejected'      => 'bg-red-100 text-red-700',
        'draft'         => 'bg-gray-100 text-gray-500',
        'featured'      => 'bg-yellow-100 text-yellow-800',
        // Default
        'default'       => 'bg-gray-100 text-gray-600',
    ];
    $classes = $map[$type] ?? $map['default'];
@endphp

<span class="inline-flex items-center text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $classes }}">
    {{ $label ?: $type }}
</span>
