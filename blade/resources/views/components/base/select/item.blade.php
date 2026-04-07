@props([
    'value' => null,
    'disabled' => false,
    'supportingText' => null,
    'avatarUrl' => null,
])

<li
    role="option"
    @click="if (!{{ $disabled ? 'true' : 'false' }}) select('{{ $value }}', $el.querySelector('[data-label]')?.textContent?.trim() || '{{ addslashes($slot->toHtml()) }}')"
    :aria-selected="selectedId === '{{ $value }}'"
    @if($disabled) aria-disabled="true" @endif
    class="{{ cx(
        'relative flex cursor-pointer select-none items-center gap-2 px-3.5 py-2.5 text-sm transition duration-100 ease-linear',
        $disabled
            ? 'cursor-not-allowed opacity-50'
            : 'hover:bg-primary_hover',
    ) }}"
    :class="{ 'bg-active': selectedId === '{{ $value }}' }"
>
    {{-- Avatar --}}
    @if($avatarUrl)
        <img
            src="{{ $avatarUrl }}"
            alt=""
            class="size-6 shrink-0 rounded-full object-cover"
        >
    @endif

    {{-- Text content --}}
    <span class="flex min-w-0 flex-1 flex-col">
        <span data-label class="truncate text-primary">{{ $slot }}</span>
        @if($supportingText)
            <span class="truncate text-xs text-tertiary">{{ $supportingText }}</span>
        @endif
    </span>

    {{-- Checkmark icon --}}
    <svg
        x-show="selectedId === '{{ $value }}'"
        x-cloak
        class="size-5 shrink-0 text-fg-brand-primary"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <path d="M20 6L9 17l-5-5"/>
    </svg>
</li>
