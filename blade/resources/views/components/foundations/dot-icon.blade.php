@props([
    'size' => 'md',
])

@php
$dimensions = match ($size) {
    'sm' => ['wh' => 8, 'c' => 4, 'r' => 2.5],
    'md' => ['wh' => 10, 'c' => 5, 'r' => 4],
};
@endphp

<svg {{ $attributes->merge([
    'width' => $dimensions['wh'],
    'height' => $dimensions['wh'],
    'viewBox' => '0 0 ' . $dimensions['wh'] . ' ' . $dimensions['wh'],
    'fill' => 'none',
]) }}>
    <circle
        cx="{{ $dimensions['c'] }}"
        cy="{{ $dimensions['c'] }}"
        r="{{ $dimensions['r'] }}"
        fill="currentColor"
        stroke="currentColor"
    />
</svg>
