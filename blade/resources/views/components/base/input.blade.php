@props([
    'size' => 'md',
    'label' => null,
    'hint' => null,
    'tooltip' => null,
    'placeholder' => null,
    'name' => null,
    'type' => 'text',
    'isRequired' => false,
    'isDisabled' => false,
    'isInvalid' => false,
])

@php
$sizes = [
    'sm' => ['wrapper' => 'px-3 py-2', 'text' => 'text-sm', 'iconOuter' => 'left-3', 'iconSize' => 'size-4', 'inputPl' => 'pl-8'],
    'md' => ['wrapper' => 'px-3.5 py-2.5', 'text' => 'text-md', 'iconOuter' => 'left-3.5', 'iconSize' => 'size-5', 'inputPl' => 'pl-10'],
    'lg' => ['wrapper' => 'px-4 py-3', 'text' => 'text-md', 'iconOuter' => 'left-4', 'iconSize' => 'size-5', 'inputPl' => 'pl-11'],
];
$s = $sizes[$size];
$isPassword = $type === 'password';
$hasIcon = isset($icon) && $icon instanceof \Illuminate\View\ComponentSlot && $icon->isNotEmpty();
@endphp

<div
    @if($isPassword) x-data="{ showPassword: false }" @endif
    {{ $attributes->only('class')->class('flex flex-col gap-1.5') }}
>
    @if($label)
        <x-untitledui::label :isRequired="$isRequired" :isInvalid="$isInvalid" :tooltip="$tooltip">
            {{ $label }}
        </x-untitledui::label>
    @endif

    <div class="{{ cx(
        'relative flex items-center rounded-lg bg-primary shadow-xs ring-1 ring-inset transition duration-100 ease-linear',
        $isInvalid ? 'ring-error focus-within:ring-2 focus-within:ring-error' : 'ring-primary focus-within:ring-2 focus-within:ring-brand',
        $isDisabled && 'cursor-not-allowed opacity-50',
    ) }}">
        {{-- Leading icon --}}
        @if($hasIcon)
            <div class="{{ cx('pointer-events-none absolute top-1/2 -translate-y-1/2 text-fg-quaternary', $s['iconOuter'], $s['iconSize']) }}">
                {{ $icon }}
            </div>
        @endif

        @if($isPassword)
            <input
                :type="showPassword ? 'text' : 'password'"
                @if($name) name="{{ $name }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($isDisabled) disabled @endif
                @if($isRequired) required @endif
                @if($isInvalid) aria-invalid="true" @endif
                {{ $attributes->except('class')->class(cx(
                    'w-full bg-transparent outline-none placeholder:text-placeholder',
                    $s['wrapper'],
                    $s['text'],
                    $hasIcon && $s['inputPl'],
                    'pr-10',
                    $isDisabled && 'cursor-not-allowed',
                )) }}
            >
        @else
            <input
                type="{{ $type }}"
                @if($name) name="{{ $name }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($isDisabled) disabled @endif
                @if($isRequired) required @endif
                @if($isInvalid) aria-invalid="true" @endif
                {{ $attributes->except('class')->class(cx(
                    'w-full bg-transparent outline-none placeholder:text-placeholder',
                    $s['wrapper'],
                    $s['text'],
                    $hasIcon && $s['inputPl'],
                    $isDisabled && 'cursor-not-allowed',
                )) }}
            >
        @endif

        {{-- Password toggle button --}}
        @if($isPassword)
            <button
                type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-fg-quaternary transition duration-100 ease-linear hover:text-fg-quaternary_hover"
                @click="showPassword = !showPassword"
                tabindex="-1"
            >
                {{-- Eye icon (show when password is hidden) --}}
                <svg x-show="!showPassword" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2.42 12.713c-.136-.215-.204-.323-.242-.49a1.2 1.2 0 0 1 0-.446c.038-.167.106-.275.242-.49C3.546 9.505 6.895 5 12 5s8.455 4.505 9.58 6.287c.136.215.204.323.242.49.029.125.029.322 0 .446-.038.167-.106.275-.242.49C20.455 14.495 17.105 19 12 19s-8.455-4.505-9.58-6.287Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                {{-- Eye-off icon (show when password is visible) --}}
                <svg x-show="showPassword" x-cloak class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.743 5.092C11.149 5.032 11.569 5 12 5c5.105 0 8.455 4.505 9.58 6.287.136.215.204.323.242.49.029.125.029.322 0 .446-.038.167-.106.275-.242.49-.225.356-.52.79-.895 1.262M6.724 6.715C4.47 8.213 2.96 10.37 2.42 11.287c-.136.215-.204.323-.242.49a1.2 1.2 0 0 0 0 .446c.038.167.106.275.242.49C3.546 14.495 6.895 19 12 19c2.06 0 3.832-.732 5.289-1.723M3 3l18 18M9.879 9.879a3 3 0 1 0 4.243 4.243"/>
                </svg>
            </button>
        @endif
    </div>

    @if($hint)
        <x-untitledui::hint-text :isInvalid="$isInvalid">
            {{ $hint }}
        </x-untitledui::hint-text>
    @endif
</div>
