@props(['contest'])

@php
    $deadline = isset($contest->deadline) ? \Carbon\Carbon::parse($contest->deadline) : null;
    $daysLeft = $deadline ? (int) floor(now()->diffInDays($deadline, false)) : null;
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
        <div class="flex flex-wrap items-center gap-1.5 mb-4">
            <x-badge :type="$contest->category->slug ?? 'default'" :label="$contest->category->name ?? 'Geral'" />

            @switch($contest->participation_type ?? '')
                @case('full_application')
                    <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-medium">Candidatura</span>
                @break
                @case('interest_submission')
                    <span class="text-xs bg-purple-50 text-purple-600 px-2 py-0.5 rounded-full font-medium">Interesse</span>
                @break
                @case('info_only')
                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-medium">Informação</span>
                @break
            @endswitch

            @if(!($contest->accepts_proposals ?? true))
                <span class="text-xs bg-orange-50 text-orange-600 px-2 py-0.5 rounded-full font-medium">Sem propostas</span>
            @endif
        </div>

        {{-- Footer: Location + Deadline --}}
        <div class="flex items-center justify-between gap-2 pt-3 border-t border-gray-50">
            {{-- Location --}}
            <span class="flex items-center gap-1 text-xs text-gray-400 min-w-0">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="truncate">{{ Str::limit($contest->city ?? $contest->country ?? 'Remoto', 18) }}</span>
            </span>

            {{-- Deadline --}}
            @if($deadline)
                <span class="flex-shrink-0 flex items-center gap-1 text-xs font-semibold rounded-full px-2.5 py-1
                    {{ $isExpired ? 'bg-gray-100 text-gray-400' : ($isUrgent ? 'bg-red-100 text-red-600' : 'bg-green-50 text-forest-green') }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    @if($isExpired)
                        Expirado
                    @elseif($daysLeft === 0)
                        Hoje!
                    @elseif($daysLeft === 1)
                        Amanhã
                    @elseif($daysLeft <= 30)
                        {{ $daysLeft }} dias
                    @else
                        {{ $deadline->format('d M Y') }}
                    @endif
                </span>
            @endif
        </div>
    </div>
</a>
