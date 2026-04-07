@props([
    'href' => null,
    'disabled' => false,
    'destructive' => false,
])

@php
$tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if($href && !$disabled) href="{{ $href }}" @endif
    @if($tag === 'button') type="button" @endif
    @if($disabled) disabled aria-disabled="true" @endif
    role="menuitem"
    {{ $attributes->class(cx(
        'flex w-full items-center gap-2 px-4 py-2.5 text-sm text-left transition duration-100 ease-linear',
        $destructive
            ? 'text-error-primary hover:bg-primary_hover'
            : 'text-secondary hover:bg-primary_hover',
        $disabled && 'cursor-not-allowed opacity-50',
    )) }}
>
    {{-- Optional icon slot --}}
    @if(isset($icon))
        <span class="{{ cx('shrink-0', $destructive ? 'text-fg-error-secondary' : 'text-fg-quaternary') }}">
            {{ $icon }}
        </span>
    @endif

    {{ $slot }}
</{{ $tag }}>
