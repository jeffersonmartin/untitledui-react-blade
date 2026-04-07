@props([
    'size' => 'md',
    'color' => 'gray',
    'closable' => false,
    'avatarSrc' => null,
    'dot' => false,
    'count' => null,
])

@php
$colorClasses = match($color) {
    'gray'    => 'bg-utility-neutral-50 text-utility-neutral-700 ring-utility-neutral-200',
    'brand'   => 'bg-utility-brand-50 text-utility-brand-700 ring-utility-brand-200',
    'error'   => 'bg-utility-red-50 text-utility-red-700 ring-utility-red-200',
    'warning' => 'bg-utility-yellow-50 text-utility-yellow-700 ring-utility-yellow-200',
    'success' => 'bg-utility-green-50 text-utility-green-700 ring-utility-green-200',
    default   => 'bg-utility-neutral-50 text-utility-neutral-700 ring-utility-neutral-200',
};

$sizeClasses = match($size) {
    'sm' => 'gap-1 py-0.5 px-1.5 text-xs font-medium',
    'md' => 'gap-1 py-0.5 px-2 text-sm font-medium',
    'lg' => 'gap-1 py-1 px-2.5 text-sm font-medium',
};
@endphp

<span {{ $attributes->class(cx(
    'inline-flex items-center rounded-md ring-1 ring-inset',
    $sizeClasses,
    $colorClasses,
)) }}>
    @if($avatarSrc)
        <img src="{{ $avatarSrc }}" alt="" class="size-4 rounded-full">
    @endif

    @if($dot)
        <svg class="text-current opacity-60" width="6" height="6" viewBox="0 0 6 6" fill="currentColor">
            <circle cx="3" cy="3" r="3"/>
        </svg>
    @endif

    {{ $slot }}

    @if($count !== null)
        <span class="text-current opacity-60">{{ $count }}</span>
    @endif

    @if($closable)
        <button type="button" class="ml-0.5 inline-flex cursor-pointer items-center rounded p-0.5 transition duration-100 hover:bg-black/10 focus-visible:outline-2 focus-visible:outline-focus-ring" aria-label="Remove">
            <svg class="size-3 stroke-[3px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    @endif
</span>
