@props([
    'sortable' => false,
    'sortDirection' => null,
    'name' => null,
])

<th {{ $attributes->class(cx(
    'px-6 py-3 text-left text-xs font-medium text-tertiary',
    $sortable && 'cursor-pointer select-none',
)) }}>
    @if($sortable)
        <button
            type="button"
            class="inline-flex items-center gap-1 text-xs font-medium text-tertiary transition duration-100 ease-linear hover:text-secondary_hover"
            @if($name)
                wire:click="sort('{{ $name }}')"
            @endif
        >
            {{ $slot }}

            {{-- Sort icon --}}
            <svg class="size-4 shrink-0" viewBox="0 0 16 16" fill="none">
                @if($sortDirection === 'asc')
                    <path d="M8 4L12 8H4L8 4Z" fill="currentColor" />
                    <path d="M8 12L4 8H12L8 12Z" fill="currentColor" opacity="0.3" />
                @elseif($sortDirection === 'desc')
                    <path d="M8 4L12 8H4L8 4Z" fill="currentColor" opacity="0.3" />
                    <path d="M8 12L4 8H12L8 12Z" fill="currentColor" />
                @else
                    <path d="M8 4L12 8H4L8 4Z" fill="currentColor" opacity="0.3" />
                    <path d="M8 12L4 8H12L8 12Z" fill="currentColor" opacity="0.3" />
                @endif
            </svg>
        </button>
    @else
        {{ $slot }}
    @endif
</th>
