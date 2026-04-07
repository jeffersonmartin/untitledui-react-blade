@props([
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'value' => 50,
    'name' => null,
    'label' => null,
    'disabled' => false,
])

<div
    x-data="{ value: @js($value) }"
    {{ $attributes->class(cx(
        'flex flex-col gap-2',
        $disabled && 'cursor-not-allowed opacity-50',
    )) }}
>
    @if($label)
        <div class="flex items-center justify-between">
            <x-untitledui::label>{{ $label }}</x-untitledui::label>
            <span class="text-sm text-secondary" x-text="value"></span>
        </div>
    @endif

    <div class="relative flex w-full items-center">
        {{-- Track --}}
        <div class="relative h-2 w-full rounded-full bg-quaternary">
            {{-- Filled track --}}
            <div
                class="absolute inset-y-0 left-0 rounded-full bg-brand-solid"
                :style="`width: ${((value - {{ $min }}) / ({{ $max }} - {{ $min }})) * 100}%`"
            ></div>
        </div>

        {{-- Native range input --}}
        <input
            type="range"
            min="{{ $min }}"
            max="{{ $max }}"
            step="{{ $step }}"
            x-model="value"
            @if($name) name="{{ $name }}" @endif
            @if($disabled) disabled @endif
            class="{{ cx(
                'absolute inset-0 h-2 w-full cursor-pointer appearance-none bg-transparent',
                '[&::-webkit-slider-thumb]:size-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-brand-solid [&::-webkit-slider-thumb]:bg-primary [&::-webkit-slider-thumb]:shadow-sm',
                '[&::-moz-range-thumb]:size-5 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-2 [&::-moz-range-thumb]:border-brand-solid [&::-moz-range-thumb]:bg-primary [&::-moz-range-thumb]:shadow-sm',
                $disabled && 'cursor-not-allowed',
            ) }}"
        >
    </div>
</div>
