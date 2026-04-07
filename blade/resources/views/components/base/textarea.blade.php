@props([
    'size' => 'md',
    'label' => null,
    'hint' => null,
    'tooltip' => null,
    'placeholder' => null,
    'name' => null,
    'isRequired' => false,
    'isDisabled' => false,
    'isInvalid' => false,
    'rows' => 4,
])

@php
$sizes = [
    'sm' => ['wrapper' => 'px-3 py-2', 'text' => 'text-sm'],
    'md' => ['wrapper' => 'px-3.5 py-2.5', 'text' => 'text-md'],
    'lg' => ['wrapper' => 'px-4 py-3', 'text' => 'text-md'],
];
$s = $sizes[$size];
@endphp

<div {{ $attributes->only('class')->class('flex flex-col gap-1.5') }}>
    @if($label)
        <x-untitledui::label :isRequired="$isRequired" :isInvalid="$isInvalid" :tooltip="$tooltip">
            {{ $label }}
        </x-untitledui::label>
    @endif

    <div class="{{ cx(
        'rounded-lg bg-primary shadow-xs ring-1 ring-inset transition duration-100 ease-linear',
        $isInvalid ? 'ring-error focus-within:ring-2 focus-within:ring-error' : 'ring-primary focus-within:ring-2 focus-within:ring-brand',
        $isDisabled && 'cursor-not-allowed opacity-50',
    ) }}">
        <textarea
            @if($name) name="{{ $name }}" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($isDisabled) disabled @endif
            @if($isRequired) required @endif
            @if($isInvalid) aria-invalid="true" @endif
            rows="{{ $rows }}"
            {{ $attributes->except('class')->class(cx(
                'w-full resize-y bg-transparent outline-none placeholder:text-placeholder',
                $s['wrapper'],
                $s['text'],
                $isDisabled && 'cursor-not-allowed',
            )) }}
        >{{ $slot }}</textarea>
    </div>

    @if($hint)
        <x-untitledui::hint-text :isInvalid="$isInvalid">
            {{ $hint }}
        </x-untitledui::hint-text>
    @endif
</div>
