@props([
    'value' => 0,
    'size' => 'md',
    'label' => null,
    'showValue' => false,
])

@php
$trackHeight = match($size) {
    'sm' => 'h-2',
    'md' => 'h-3',
};
$clampedValue = max(0, min(100, $value));
@endphp

<div {{ $attributes->class('flex flex-col gap-2') }}>
    @if($label || $showValue)
        <div class="flex items-center justify-between">
            @if($label)
                <span class="text-sm font-medium text-secondary">{{ $label }}</span>
            @endif
            @if($showValue)
                <span class="text-sm font-medium text-secondary">{{ $clampedValue }}%</span>
            @endif
        </div>
    @endif

    <div class="{{ cx('w-full overflow-hidden rounded-full bg-quaternary', $trackHeight) }}">
        <div
            class="{{ cx('rounded-full bg-brand-solid transition-all duration-300 ease-out', $trackHeight) }}"
            style="width: {{ $clampedValue }}%"
            role="progressbar"
            aria-valuenow="{{ $clampedValue }}"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
    </div>
</div>
