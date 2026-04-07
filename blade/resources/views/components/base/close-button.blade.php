@props([
    'size' => 'sm',
    'theme' => 'light',
    'label' => 'Close',
])

@php
$sizeClasses = match($size) {
    'xs' => ['root' => 'size-7', 'icon' => 'size-4'],
    'sm' => ['root' => 'size-9', 'icon' => 'size-5'],
    'md' => ['root' => 'size-10', 'icon' => 'size-5'],
    'lg' => ['root' => 'size-11', 'icon' => 'size-6'],
};

$themeClasses = match($theme) {
    'light' => 'text-fg-quaternary hover:bg-primary_hover hover:text-fg-quaternary_hover focus-visible:outline-2 focus-visible:outline-offset-2 outline-focus-ring',
    'dark' => 'text-fg-white/70 hover:text-fg-white hover:bg-white/20 focus-visible:outline-2 focus-visible:outline-offset-2 outline-focus-ring',
};
@endphp

<button
    type="button"
    aria-label="{{ $label }}"
    {{ $attributes->class(cx(
        'flex cursor-pointer items-center justify-center rounded-lg p-2 transition duration-100 ease-linear focus:outline-hidden',
        $sizeClasses['root'],
        $themeClasses,
    )) }}
>
    {{-- X / Close icon --}}
    <svg aria-hidden="true" class="{{ cx('shrink-0 transition-inherit-all', $sizeClasses['icon']) }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
</button>
