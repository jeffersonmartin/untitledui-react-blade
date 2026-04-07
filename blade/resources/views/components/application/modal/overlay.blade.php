@props([
    'maxWidth' => 'lg',
])

@php
$maxWidthClass = match($maxWidth) {
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
};
@endphp

<div
    x-data="{ open: false }"
    @open-modal.window="open = true"
    @keydown.escape.window="open = false"
    {{ $attributes }}
>
    {{-- Trigger --}}
    @if(isset($trigger))
        <div @click="open = true">
            {{ $trigger }}
        </div>
    @endif

    {{-- Modal --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed inset-0 z-50 flex items-end justify-center bg-overlay/70 backdrop-blur-[6px] sm:items-center"
            @click.self="open = false"
        >
            <div
                x-show="open"
                x-trap.noscroll="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="{{ cx(
                    'w-full rounded-xl bg-primary shadow-xl outline-hidden sm:rounded-2xl',
                    $maxWidthClass,
                ) }}"
            >
                {{ $slot }}
            </div>
        </div>
    </template>
</div>
