@props([
    'href' => null,
    'active' => false,
    'icon' => null,
    'badge' => null,
    'collapsible' => false,
])

@php
$tag = $href ? 'a' : 'button';
$baseClasses = 'group flex w-full items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition duration-100 ease-linear';
$activeClasses = $active ? 'bg-active text-secondary_hover' : 'text-tertiary hover:bg-primary_hover hover:text-secondary_hover';
@endphp

@if($collapsible)
    <div x-data="{ expanded: {{ $active ? 'true' : 'false' }} }">
        <button
            type="button"
            @click="expanded = !expanded"
            {{ $attributes->class(cx($baseClasses, $activeClasses, 'justify-between')) }}
        >
            <span class="flex items-center gap-3">
                @if($icon)
                    <span class="text-fg-quaternary group-hover:text-fg-quaternary_hover">{{ $icon }}</span>
                @endif
                {{ $slot }}
            </span>
            {{-- Chevron --}}
            <svg class="size-5 text-fg-quaternary transition-transform duration-200" :class="{ 'rotate-180': expanded }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </button>

        <div x-show="expanded" x-collapse>
            @isset($children)
                <div class="ml-9 mt-1 flex flex-col gap-1">
                    {{ $children }}
                </div>
            @endisset
        </div>
    </div>
@else
    <{{ $tag }}
        @if($href) href="{{ $href }}" @else type="button" @endif
        {{ $attributes->class(cx($baseClasses, $activeClasses)) }}
    >
        @if($icon)
            <span class="text-fg-quaternary group-hover:text-fg-quaternary_hover">{{ $icon }}</span>
        @endif
        <span class="flex-1 text-left">{{ $slot }}</span>
        @if($badge)
            {{ $badge }}
        @endif
    </{{ $tag }}>
@endif
