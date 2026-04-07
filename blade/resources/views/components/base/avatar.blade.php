@props([
    'size' => 'md',
    'src' => null,
    'alt' => '',
    'initials' => null,
    'contrastBorder' => false,
    'rounded' => true,
    'border' => false,
    'status' => null,
    'verified' => false,
    'count' => null,
    'focusable' => false,
])

@php
$styles = [
    'xs'  => ['root' => 'size-6',  'rootWithBorder' => 'p-px',       'initials' => 'text-xs font-semibold',         'icon' => 'size-4'],
    'sm'  => ['root' => 'size-8',  'rootWithBorder' => 'p-px',       'initials' => 'text-sm font-semibold',         'icon' => 'size-5'],
    'md'  => ['root' => 'size-10', 'rootWithBorder' => 'p-px',       'initials' => 'text-md font-semibold',         'icon' => 'size-6'],
    'lg'  => ['root' => 'size-12', 'rootWithBorder' => 'p-[1.5px]',  'initials' => 'text-lg font-semibold',         'icon' => 'size-7'],
    'xl'  => ['root' => 'size-14', 'rootWithBorder' => 'p-0.5',      'initials' => 'text-xl font-semibold',         'icon' => 'size-8'],
    '2xl' => ['root' => 'size-16', 'rootWithBorder' => 'p-0.5',      'initials' => 'text-display-xs font-semibold', 'icon' => 'size-8'],
];
$s = $styles[$size];
@endphp

<div
    data-avatar
    {{ $attributes->class(cx(
        'relative inline-flex shrink-0 rounded-[7px]',
        $rounded && 'rounded-full',
        $focusable && 'outline-transparent group-focus-visible:outline-2 group-focus-visible:outline-offset-2 group-focus-visible:outline-focus-ring',
        $border && 'ring-1 ring-secondary_alt',
        $border && $s['rootWithBorder'],
        $s['root'],
    )) }}
>
    <div class="{{ cx(
        'relative inline-flex size-full shrink-0 items-center justify-center overflow-hidden rounded-md bg-tertiary outline-[0.5px] -outline-offset-[0.5px] outline-black/16 before:inset-[0.5px]',
        $rounded && 'rounded-full',
    ) }}">
        @if($src)
            <img data-avatar-img class="size-full object-cover" src="{{ $src }}" alt="{{ $alt }}">
        @elseif($initials)
            <span class="{{ cx('text-quaternary', $s['initials']) }}">{{ $initials }}</span>
        @elseif($slot->isNotEmpty())
            {{ $slot }}
        @else
            {{-- Default user icon --}}
            <svg class="{{ cx('text-fg-quaternary', $s['icon']) }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        @endif
    </div>

    @if($status)
        @php
        $indicatorSizes = match($size) {
            'xs'  => 'size-1.5 ring-[1.5px]',
            'sm'  => 'size-2 ring-[1.5px]',
            'md'  => 'size-2.5 ring-[1.5px]',
            'lg'  => 'size-3 ring-2',
            'xl'  => 'size-3.5 ring-2',
            '2xl' => 'size-4 ring-[2.5px]',
        };
        @endphp
        <span class="{{ cx(
            'absolute right-0 bottom-0 rounded-full ring-white',
            $status === 'online' ? 'bg-fg-success-secondary' : 'bg-quaternary',
            $indicatorSizes,
        ) }}"></span>
    @endif

    @if($verified)
        @php
        $verifiedSizes = match($size) {
            'xs'  => 'size-3',
            'sm'  => 'size-4',
            'md'  => 'size-5',
            'lg'  => 'size-5',
            'xl'  => 'size-6',
            '2xl' => 'size-7',
        };
        @endphp
        <svg class="{{ cx('absolute right-0 bottom-0', $verifiedSizes, $size === 'xs' && '-right-px -bottom-px') }}" viewBox="0 0 16 16" fill="none">
            <path d="M5.37 1.598A2.5 2.5 0 0 1 8 0a2.5 2.5 0 0 1 2.63 1.598 2.5 2.5 0 0 1 3.05 1.722A2.5 2.5 0 0 1 15.402 5.37 2.5 2.5 0 0 1 16 8a2.5 2.5 0 0 1-1.598 2.63 2.5 2.5 0 0 1-1.722 3.05A2.5 2.5 0 0 1 10.63 15.402 2.5 2.5 0 0 1 8 16a2.5 2.5 0 0 1-2.63-1.598 2.5 2.5 0 0 1-3.05-1.722A2.5 2.5 0 0 1 .598 10.63 2.5 2.5 0 0 1 0 8a2.5 2.5 0 0 1 1.598-2.63A2.5 2.5 0 0 1 3.32 2.32 2.5 2.5 0 0 1 5.37 1.598Z" fill="var(--color-fg-brand-primary)"/>
            <path d="M11.2 5.6 6.8 10.4 4.8 8.4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @endif

    @if($count)
        <span class="absolute -top-1 -right-1 flex size-5 items-center justify-center rounded-full bg-error-solid text-xs font-medium text-white ring-[1.5px] ring-white">
            {{ $count > 9 ? '9+' : $count }}
        </span>
    @endif

    @isset($badge)
        {{ $badge }}
    @endisset
</div>
