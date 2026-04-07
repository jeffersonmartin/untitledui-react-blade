@props([
    'title' => '',
    'description' => null,
    'arrow' => false,
    'placement' => 'top',
])

<span
    x-data="{ show: false }"
    @mouseenter="show = true"
    @mouseleave="show = false"
    @focus.capture="show = true"
    @blur.capture="show = false"
    class="relative inline-flex"
>
    {{-- Trigger --}}
    {{ $slot }}

    {{-- Tooltip content --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        role="tooltip"
        class="{{ cx(
            'absolute z-50 flex max-w-xs flex-col items-start gap-1 rounded-lg bg-primary-solid px-3 shadow-lg',
            $description ? 'py-3' : 'py-2',
            match($placement) {
                'top'    => 'bottom-full left-1/2 mb-1.5 -translate-x-1/2',
                'bottom' => 'top-full left-1/2 mt-1.5 -translate-x-1/2',
                'left'   => 'right-full top-1/2 mr-1.5 -translate-y-1/2',
                'right'  => 'left-full top-1/2 ml-1.5 -translate-y-1/2',
                default  => 'bottom-full left-1/2 mb-1.5 -translate-x-1/2',
            },
        ) }}"
    >
        <span class="text-xs font-semibold text-white">{{ $title }}</span>

        @if($description)
            <span class="text-xs font-medium text-tooltip-supporting-text">{{ $description }}</span>
        @endif

        @if($arrow)
            <svg
                viewBox="0 0 100 100"
                class="{{ cx(
                    'absolute size-2.5 fill-bg-primary-solid',
                    match($placement) {
                        'top'    => 'top-full left-1/2 -translate-x-1/2 rotate-180',
                        'bottom' => 'bottom-full left-1/2 -translate-x-1/2 rotate-0',
                        'left'   => 'left-full top-1/2 -translate-y-1/2 rotate-90',
                        'right'  => 'right-full top-1/2 -translate-y-1/2 -rotate-90',
                        default  => 'top-full left-1/2 -translate-x-1/2 rotate-180',
                    },
                ) }}"
            >
                <path d="M0,0 L35.858,35.858 Q50,50 64.142,35.858 L100,0 Z" />
            </svg>
        @endif
    </div>
</span>
