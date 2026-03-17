@props(['contest'])

@php
    $deadline = isset($contest->deadline) ? \Carbon\Carbon::parse($contest->deadline) : null;
    $daysLeft = $deadline ? now()->diffInDays($deadline, false) : null;
    $isExpired = $daysLeft !== null && $daysLeft < 0;
    $isUrgent  = $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 5;
@endphp

<a href="{{ route('contests.show', $contest->slug) }}"
   class="group block bg-white rounded-2xl border border-gray-100 shadow-sm
          hover:shadow-lg hover:-translate-y-1 hover:border-terracota/30
          transition-all duration-200 overflow-hidden">

    {{-- Top stripe by category --}}
    <div class="h-1 w-full"
         style="background: linear-gradient(90deg, {{ $contest->category->color ?? '#C0602A' }}, {{ $contest->category->secondary_color ?? '#D4A017' }});"></div>

    <div class="p-5">

        {{-- Header: Logo + Company --}}
        <div class="flex items-start gap-3 mb-4">
            <div class="w-12 h-12 flex-shrink-0 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center">
                @if($contest->company->logo ?? false)
                    <img src="{{ Storage::url($contest->company->logo) }}"
                         alt="{{ $contest->company->name }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-bold text-gray-400">
                        {{ strtoupper(substr($contest->company->name ?? 'C', 0, 2)) }}
                    </span>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-gray-500 truncate">{{ $contest->company->name ?? 'Empresa' }}</p>
                <h3 class="text-sm font-bold text-gray-900 group-hover:text-terracota transition leading-snug line-clamp-2 mt-0.5">
                    {{ $contest->title }}
                </h3>
            </div>
            {{-- Featured badge --}}
            @if($contest->is_featured ?? false)
                <span class="flex-shrink-0 text-xs bg-golden text-gray-900 px-1.5 py-0.5 rounded font-bold">★</span>
            @endif
        </div>

        {{-- Description snippet --}}
        @if($contest->description ?? false)
            <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-4">
                {{ Str::limit(strip_tags($contest->description), 120) }}
            </p>
        @endif

        {{-- Tags row --}}
        <div class="flex flex-wrap items-center gap-2 mb-4">
            {{-- Category --}}
            <x-badge :type="$contest->category->slug ?? 'default'" :label="$contest->category->name ?? 'Geral'" />

            {{-- Participation type --}}
            @switch($contest->participation_type ?? '')
                @case('full_application')
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-medium">Candidatura</span>
                @break
                @case('interest_submission')
                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full font-medium">Interesse</span>
                @break
                @case('info_only')
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-medium">Informação</span>
                @break
            @endswitch
        </div>

        {{-- Footer: Location + Deadline --}}
        <div class="flex items-center justify-between pt-3 border-t border-gray-50">
            <span class="flex items-center gap-1 text-xs text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ Str::limit($contest->location ?? 'Remoto', 20) }}
            </span>

            {{-- Deadline countdown --}}
            @if($deadline)
                <span class="flex items-center gap-1 text-xs font-semibold rounded-full px-2 py-0.5
                    {{ $isExpired ? 'bg-gray-100 text-gray-400' : ($isUrgent ? 'bg-red-100 text-red-600' : 'bg-green-100 text-forest-green') }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @if($isExpired)
                        Expirado
                    @elseif($daysLeft === 0)
                        Hoje!
                    @elseif($daysLeft === 1)
                        1 dia
                    @elseif($daysLeft <= 30)
                        {{ $daysLeft }} dias
                    @else
                        {{ $deadline->format('d/m/Y') }}
                    @endif
                </span>
            @endif
        </div>
    </div>
</a>
