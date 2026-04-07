@props([
    'size' => 'sm',
    'label' => null,
    'hint' => null,
    'name' => null,
    'value' => '',
    'checked' => false,
    'disabled' => false,
])

@php
$sizes = [
    'sm' => ['root' => 'gap-2', 'label' => 'text-sm font-medium', 'hint' => 'text-sm'],
    'md' => ['root' => 'gap-3', 'label' => 'text-md font-medium', 'hint' => 'text-md'],
];
$s = $sizes[$size];
@endphp

<label {{ $attributes->class(cx(
    'flex items-start',
    $disabled && 'cursor-not-allowed',
    $s['root'],
)) }}>
    <input
        type="radio"
        class="peer sr-only"
        @if($name) name="{{ $name }}" @endif
        value="{{ $value }}"
        @if($checked) checked @endif
        @if($disabled) disabled @endif
    >

    {{-- Visual radio --}}
    <div class="{{ cx(
        'flex size-4 shrink-0 cursor-pointer appearance-none items-center justify-center rounded-full bg-primary ring-1 ring-primary ring-inset transition duration-100 ease-linear',
        $size === 'md' && 'size-5',
        ($label || $hint) && 'mt-0.5',
        $disabled && 'cursor-not-allowed opacity-50',
    ) }} peer-checked:bg-brand-solid peer-checked:ring-brand-solid peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-focus-ring {{ $disabled && !$checked ? 'bg-tertiary' : '' }}">
        <div class="{{ cx(
            'size-1.5 rounded-full bg-fg-white opacity-0 transition-inherit-all',
            $size === 'md' && 'size-2',
        ) }} peer-checked:opacity-100"></div>
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
