@props([
    'size' => 'md',
    'label' => null,
    'hint' => null,
    'tooltip' => null,
    'placeholder' => 'Select...',
    'searchPlaceholder' => 'Search...',
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
        search: '',
        selectedId: null,
        selectedLabel: '',
        highlightedIndex: -1,
        items: @js($items),
        get filteredItems() {
            if (!this.search) return this.items;
            const q = this.search.toLowerCase();
            return this.items.filter(item => {
                const label = (item.label || item.name || '').toLowerCase();
                const support = (item.supportingText || '').toLowerCase();
                return label.includes(q) || support.includes(q);
            });
        },
        toggle() { if (!{{ $isDisabled ? 'true' : 'false' }}) { this.open = !this.open; if (this.open) this.$nextTick(() => this.$refs.searchInput?.focus()); } },
        select(id, label) { this.selectedId = id; this.selectedLabel = label; this.open = false; this.search = ''; },
        close() { this.open = false; this.search = ''; },
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
        @keydown.arrow-down.prevent="open = true"
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

    {{-- Dropdown popover with search --}}
    <div
        x-show="open"
        x-transition:enter="transition duration-100 ease-out"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        x-cloak
        class="absolute z-50 mt-1 w-full overflow-hidden rounded-lg bg-primary shadow-lg ring-1 ring-secondary_alt"
    >
        {{-- Search input --}}
        <div class="border-b border-secondary px-3 py-2">
            <div class="flex items-center gap-2">
                {{-- Search icon --}}
                <svg class="size-5 shrink-0 text-fg-quaternary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input
                    x-ref="searchInput"
                    x-model="search"
                    type="text"
                    placeholder="{{ $searchPlaceholder }}"
                    @keydown.arrow-down.prevent="highlightedIndex = Math.min(highlightedIndex + 1, filteredItems.length - 1)"
                    @keydown.arrow-up.prevent="highlightedIndex = Math.max(highlightedIndex - 1, 0)"
                    @keydown.enter.prevent="if (highlightedIndex >= 0 && filteredItems[highlightedIndex]) { select(filteredItems[highlightedIndex].id, filteredItems[highlightedIndex].label || filteredItems[highlightedIndex].name) }"
                    class="w-full border-0 bg-transparent text-sm text-primary placeholder:text-placeholder focus:outline-none"
                >
            </div>
        </div>

        {{-- Items list --}}
        <ul
            x-ref="listbox"
            role="listbox"
            class="max-h-60 overflow-auto py-1"
        >
            {{-- Render from items array --}}
            <template x-for="(item, index) in filteredItems" :key="item.id">
                <li
                    role="option"
                    @click="select(item.id, item.label || item.name)"
                    :aria-selected="selectedId === item.id"
                    class="relative flex cursor-pointer select-none items-center gap-2 px-3.5 py-2.5 text-sm transition duration-100 ease-linear hover:bg-primary_hover"
                    :class="{
                        'bg-active': selectedId === item.id,
                        'bg-primary_hover': highlightedIndex === index,
                    }"
                >
                    {{-- Avatar --}}
                    <template x-if="item.avatarUrl">
                        <img :src="item.avatarUrl" alt="" class="size-6 shrink-0 rounded-full object-cover">
                    </template>

                    {{-- Text --}}
                    <span class="flex min-w-0 flex-1 flex-col">
                        <span class="truncate text-primary" x-text="item.label || item.name"></span>
                        <template x-if="item.supportingText">
                            <span class="truncate text-xs text-tertiary" x-text="item.supportingText"></span>
                        </template>
                    </span>

                    {{-- Checkmark --}}
                    <svg
                        x-show="selectedId === item.id"
                        class="size-5 shrink-0 text-fg-brand-primary"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    >
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                </li>
            </template>

            {{-- Empty state --}}
            <li x-show="filteredItems.length === 0" class="px-3.5 py-2.5 text-sm text-tertiary">
                No results found.
            </li>

            {{-- Slot for server-rendered items --}}
            {{ $slot }}
        </ul>
    </div>

    {{-- Hint text --}}
    @if($hint)
        <x-untitledui::hint-text :isInvalid="$isInvalid" class="mt-1.5">
            {{ $hint }}
        </x-untitledui::hint-text>
    @endif
</div>
