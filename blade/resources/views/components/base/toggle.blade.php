@props([
    'size' => 'sm',
    'slim' => false,
    'label' => null,
    'hint' => null,
    'name' => null,
    'checked' => false,
    'disabled' => false,
])

@php
$labelSizes = [
    'sm' => ['root' => 'gap-2', 'label' => 'text-sm font-medium', 'hint' => 'text-sm'],
    'md' => ['root' => 'gap-3', 'label' => 'text-md font-medium', 'hint' => 'text-md'],
];
$s = $labelSizes[$size];

$trackClasses = match(true) {
    $slim && $size === 'sm' => 'h-4 w-8',
    $slim && $size === 'md' => 'h-5 w-10',
    !$slim && $size === 'sm' => 'h-5 w-9 p-0.5',
    !$slim && $size === 'md' => 'h-6 w-11 p-0.5',
};

$thumbSize = match(true) {
    $size === 'sm' => 'size-4',
    $size === 'md' => 'size-5',
};

$thumbTranslate = match(true) {
    $size === 'sm' => 'translate-x-4',
    $size === 'md' => 'translate-x-5',
};
@endphp

<label
    x-data="{ on: @js($checked) }"
    {{ $attributes->class(cx(
        'flex w-max items-start',
        $disabled && 'cursor-not-allowed',
        $s['root'],
    )) }}
>
    <input
        type="checkbox"
        class="sr-only"
        @if($name) name="{{ $name }}" @endif
        x-model="on"
        @if($disabled) disabled @endif
        role="switch"
        :aria-checked="on.toString()"
    >

    {{-- Toggle track --}}
    <div
        class="{{ cx(
            'cursor-pointer rounded-full bg-tertiary ring-[0.5px] ring-secondary outline-focus-ring transition duration-150 ease-linear ring-inset',
            $disabled && 'cursor-not-allowed opacity-50',
            $slim && 'ring-1',
            $slim && $size === 'sm' && 'mt-0.5',
            $trackClasses,
        ) }}"
        :class="{
            'bg-brand-solid': on,
            '!ring-transparent': on && {{ $slim ? 'true' : 'false' }},
        }"
    >
        {{-- Toggle thumb --}}
        <div
            class="{{ cx(
                'rounded-full bg-fg-white shadow-sm transition-transform duration-150 ease-in-out',
                $slim && 'shadow-xs border border-toggle-border',
                $thumbSize,
            ) }}"
            :class="{
                '{{ $thumbTranslate }}': on,
                'border-toggle-slim-border_pressed': on && {{ $slim ? 'true' : 'false' }},
            }"
        ></div>
    </div>

    @if($label || $hint)
        <div class="{{ cx('flex flex-col', $size === 'md' && 'gap-0.5') }}">
            @if($label)
                <p class="{{ cx('text-secondary select-none', $s['label']) }}">{{ $label }}</p>
            @endif
            @if($hint)
                <span class="{{ cx('text-tertiary', $s['hint']) }}">{{ $hint }}</span>
            @endif
        </div>
    @endif
</label>
