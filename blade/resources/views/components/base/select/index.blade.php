@props([
    'size' => 'md',
    'label' => null,
    'hint' => null,
    'tooltip' => null,
    'placeholder' => 'Select...',
    'name' => null,
    'isRequired' => false,
    'isDisabled' => false,
    'isInvalid' => false,
    'items' => [],
])

@php
$sizes = [
    'sm' => [
        'trigger' => 'py-2 px-3 text-sm',
        'icon' => 'size-4',
    ],
    'md' => [
        'trigger' => 'py-2.5 px-3.5 text-sm',
        'icon' => 'size-5',
    ],
    'lg' => [
        'trigger' => 'py-3 px-4 text-md',
        'icon' => 'size-5',
    ],
];
$s = $sizes[$size];
@endphp

<div
    x-data="{
        open: false,
        selectedId: null,
        selectedLabel: '',
        highlightedIndex: -1,
        toggle() { if (!{{ $isDisabled ? 'true' : 'false' }}) this.open = !this.open },
        select(id, label) { this.selectedId = id; this.selectedLabel = label; this.open = false; },
        close() { this.open = false },
    }"
    @keydown.escape.window="close()"
    @click.outside="close()"
    {{ $attributes->class(cx('relative w-full')) }}
>
    {{-- Label --}}
    @if($label)
        <x-untitledui::label :isRequired="$isRequired" :isInvalid="$isInvalid" :tooltip="$tooltip" class="mb-1.5">
            {{ $label }}
        </x-untitledui::label>
    @endif

    {{-- Hidden input for form submission --}}
    @if($name)
        <input type="hidden" name="{{ $name }}" x-bind:value="selectedId">
    @endif

    {{-- Trigger button --}}
    <button
        type="button"
        @click="toggle()"
        @keydown.arrow-down.prevent="open = true; highlightedIndex = Math.min(highlightedIndex + 1, $refs.listbox.children.length - 1)"
        @keydown.arrow-up.prevent="open = true; highlightedIndex = Math.max(highlightedIndex - 1, 0)"
        @keydown.enter.prevent="if (open && highlightedIndex >= 0) { $refs.listbox.children[highlightedIndex]?.click() } else { toggle() }"
        :aria-expanded="open"
        aria-haspopup="listbox"
        @if($isDisabled) disabled aria-disabled="true" @endif
        class="{{ cx(
            'flex w-full cursor-pointer items-center justify-between gap-2 rounded-lg bg-primary shadow-xs ring-1 ring-inset transition duration-100 ease-linear',
            $s['trigger'],
            $isInvalid
                ? 'ring-error focus:ring-2 focus:ring-error'
                : 'ring-primary focus:ring-2 focus:ring-brand',
            $isDisabled && 'cursor-not-allowed opacity-50',
        ) }}"
    >
        <span class="flex items-center gap-2 truncate">
            {{-- Optional leading icon slot --}}
            @if(isset($icon))
                <span class="{{ cx('shrink-0 text-fg-quaternary', $s['icon']) }}">
                    {{ $icon }}
                </span>
            @endif

            <span
                class="truncate"
                :class="selectedLabel ? 'text-primary' : 'text-placeholder'"
                x-text="selectedLabel || '{{ $placeholder }}'"
            ></span>
        </span>

        {{-- Chevron down icon --}}
        <svg class="{{ cx('shrink-0 text-fg-quaternary', $s['icon']) }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
        </svg>
    </button>

    {{-- Dropdown popover --}}
    <ul
        x-ref="listbox"
        x-show="open"
        x-transition:enter="transition duration-100 ease-out"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        x-cloak
        role="listbox"
        class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-lg bg-primary py-1 shadow-lg ring-1 ring-secondary_alt"
    >
        {{ $slot }}
    </ul>

    {{-- Hint text --}}
    @if($hint)
        <x-untitledui::hint-text :isInvalid="$isInvalid" class="mt-1.5">
            {{ $hint }}
        </x-untitledui::hint-text>
    @endif
</div>
