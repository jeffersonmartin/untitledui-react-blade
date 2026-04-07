@props([
    'align' => 'left',
])

<div
    x-data="{ open: false }"
    @click.outside="open = false"
    @keydown.escape.window="open = false"
    {{ $attributes->class(cx('relative inline-block')) }}
>
    {{-- Trigger --}}
    <div @click="open = !open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    {{-- Popover menu --}}
    <div
        x-show="open"
        x-transition:enter="transition duration-100 ease-out"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        x-cloak
        @click="open = false"
        role="menu"
        class="{{ cx(
            'absolute z-50 mt-1 min-w-[200px] rounded-lg bg-primary py-1 shadow-lg ring-1 ring-secondary_alt',
            $align === 'right' ? 'right-0' : 'left-0',
        ) }}"
    >
        {{ $slot }}
    </div>
</div>
