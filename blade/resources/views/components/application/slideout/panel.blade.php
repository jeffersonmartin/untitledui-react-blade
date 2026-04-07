@props([
    'maxWidth' => 'md',
])

@php
$maxWidthClass = match($maxWidth) {
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
};
@endphp

<div
    x-data="{ open: false }"
    @open-slideout.window="open = true"
    @keydown.escape.window="open = false"
    {{ $attributes }}
>
    {{-- Trigger --}}
    @if(isset($trigger))
        <div @click="open = true">
            {{ $trigger }}
        </div>
    @endif

    {{-- Slideout --}}
    <template x-teleport="body">
        {{-- Overlay --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed inset-0 z-50 bg-overlay/70 backdrop-blur-[6px]"
            @click.self="open = false"
        ></div>

        {{-- Panel --}}
        <div
            x-show="open"
            x-trap.noscroll="open"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            x-cloak
            class="{{ cx(
                'fixed right-0 top-0 z-50 h-full w-full bg-primary shadow-xl outline-hidden',
                $maxWidthClass,
            ) }}"
        >
            {{ $slot }}
        </div>
    </template>
</div>
