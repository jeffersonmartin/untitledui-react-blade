@php
$isIconOnly = ($iconLeading || $iconTrailing) && $slot->isEmpty();
$linkSizeClasses = $isLinkType ? match($size) {
    'xs', 'sm' => 'gap-1',
    'md', 'lg', 'xl' => 'gap-1',
} : '';
$iconOnlyClass = $isIconOnly ? match($size) {
    'xs' => 'data-icon-only:p-2',
    'sm' => 'data-icon-only:p-2',
    'md' => 'data-icon-only:p-2.5',
    'lg' => 'data-icon-only:p-3',
    'xl' => 'data-icon-only:p-3.5',
} : '';
$iconSizeClass = match($size) {
    'xs' => 'size-4 stroke-[2.25px]',
    default => 'size-5',
};
@endphp

<{{ $tag }}
    @if($tag === 'a')
        @if($href && !$isDisabled) href="{{ $href }}" @endif
    @else
        type="{{ $type }}"
        @if($isDisabled) disabled @endif
    @endif
    @if($isDisabled) aria-disabled="true" @endif
    @if($isIconOnly) data-icon-only @endif
    @if($isLoading) data-loading @endif
    {{ $attributes->class(cx(
        $baseClasses,
        $sizeClasses,
        $colorClasses,
        $isLinkType && $linkSizeClasses,
        $isIconOnly && $iconOnlyClass,
        ($isLoading || ($href && $isDisabled)) && 'pointer-events-none',
    )) }}
>
    {{-- Leading icon --}}
    @if($iconLeading)
        @if($iconLeading instanceof \Illuminate\View\ComponentSlot)
            {{ $iconLeading }}
        @else
            <svg data-icon="leading" class="{{ cx($iconClasses, $iconSizeClass) }}">
                <use href="#icon-{{ $iconLeading }}"/>
            </svg>
        @endif
    @endif

    {{-- Loading spinner --}}
    @if($isLoading)
        <svg
            fill="none"
            data-icon="loading"
            viewBox="0 0 20 20"
            class="{{ cx($iconClasses, !$showTextWhileLoading && 'absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2') }}"
        >
            <circle class="stroke-current opacity-30" cx="10" cy="10" r="8" fill="none" stroke-width="2" />
            <circle
                class="origin-center animate-spin stroke-current"
                cx="10" cy="10" r="8" fill="none"
                stroke-width="2" stroke-dasharray="12.5 50" stroke-linecap="round"
            />
        </svg>
    @endif

    {{-- Text content --}}
    @if($slot->isNotEmpty())
        <span data-text class="{{ cx(
            'transition-inherit-all',
            !$isLinkType && 'px-0.5',
            $isLoading && !$showTextWhileLoading && 'invisible',
        ) }}">
            {{ $slot }}
        </span>
    @endif

    {{-- Trailing icon --}}
    @if($iconTrailing)
        @if($iconTrailing instanceof \Illuminate\View\ComponentSlot)
            {{ $iconTrailing }}
        @else
            <svg data-icon="trailing" class="{{ cx($iconClasses, $iconSizeClass, $isLoading && !$showTextWhileLoading && 'invisible') }}">
                <use href="#icon-{{ $iconTrailing }}"/>
            </svg>
        @endif
    @endif
</{{ $tag }}>
