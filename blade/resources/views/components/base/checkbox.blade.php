@props([
    'size' => 'sm',
    'label' => null,
    'hint' => null,
    'name' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'indeterminate' => false,
])

@php
$sizes = [
    'sm' => ['root' => 'gap-2', 'label' => 'text-sm font-medium', 'hint' => 'text-sm'],
    'md' => ['root' => 'gap-3', 'label' => 'text-md font-medium', 'hint' => 'text-md'],
];
$s = $sizes[$size];
@endphp

<label
    x-data="{ checked: @js($checked), indeterminate: @js($indeterminate) }"
    {{ $attributes->class(cx(
        'flex items-start',
        $disabled && 'cursor-not-allowed',
        $s['root'],
    )) }}
>
    <input
        type="checkbox"
        class="peer sr-only"
        @if($name) name="{{ $name }}" @endif
        value="{{ $value }}"
        x-model="checked"
        @if($disabled) disabled @endif
        x-ref="checkbox"
        x-init="$refs.checkbox.indeterminate = indeterminate"
    >

    {{-- Visual checkbox --}}
    <div class="{{ cx(
        'relative flex size-4 shrink-0 cursor-pointer appearance-none items-center justify-center rounded bg-primary ring-1 ring-primary ring-inset transition duration-100 ease-linear',
        $size === 'md' && 'size-5 rounded-md',
        ($label || $hint) && 'mt-0.5',
        $disabled && 'cursor-not-allowed opacity-50',
    ) }}"
        :class="{
            'bg-brand-solid ring-brand-solid': checked || indeterminate,
            'bg-tertiary': {{ $disabled ? 'true' : 'false' }} && !(checked || indeterminate),
            'outline-2 outline-offset-2 outline-focus-ring': $el.parentElement.querySelector('input:focus-visible'),
        }"
    >
        {{-- Indeterminate icon --}}
        <svg aria-hidden="true" viewBox="0 0 14 14" fill="none"
            class="{{ cx('pointer-events-none absolute h-3 w-2.5 text-fg-white opacity-0 transition-inherit-all', $size === 'md' && 'size-3.5') }}"
            :class="{ 'opacity-100': indeterminate }"
        >
            <path d="M2.91675 7H11.0834" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        {{-- Checkmark icon --}}
        <svg aria-hidden="true" viewBox="0 0 14 14" fill="none"
            class="{{ cx('pointer-events-none absolute size-3 text-fg-white opacity-0 transition-inherit-all', $size === 'md' && 'size-3.5') }}"
            :class="{ 'opacity-100': checked && !indeterminate }"
        >
            <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>

    @if($label || $hint)
        <div class="{{ cx('inline-flex flex-col', $size === 'md' && 'gap-0.5') }}">
            @if($label)
                <p class="{{ cx('text-secondary select-none', $s['label']) }}">{{ $label }}</p>
            @endif
            @if($hint)
                <span class="{{ cx('text-tertiary', $s['hint']) }}">{{ $hint }}</span>
            @endif
        </div>
    @endif
</label>
