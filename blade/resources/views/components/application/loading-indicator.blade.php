@props([
    'size' => 'md',
])

@php
$sizeClass = match($size) {
    'sm' => 'size-5',
    'md' => 'size-8',
    'lg' => 'size-12',
};
@endphp

<svg
    fill="none"
    viewBox="0 0 20 20"
    aria-label="Loading"
    role="status"
    {{ $attributes->class(cx($sizeClass, 'text-brand-secondary')) }}
>
    <circle class="stroke-current opacity-30" cx="10" cy="10" r="8" fill="none" stroke-width="2" />
    <circle
        class="origin-center animate-spin stroke-current"
        cx="10" cy="10" r="8" fill="none"
        stroke-width="2" stroke-dasharray="12.5 50" stroke-linecap="round"
    />
</svg>
