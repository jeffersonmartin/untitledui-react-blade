@props([
    'currentPage' => 1,
    'totalPages' => 1,
    'baseUrl' => '?page=',
])

@php
$currentPage = (int) $currentPage;
$totalPages = (int) $totalPages;

// Build page range with ellipsis
$pages = [];
if ($totalPages <= 7) {
    $pages = range(1, $totalPages);
} else {
    $pages[] = 1;
    if ($currentPage > 3) {
        $pages[] = '...';
    }
    $start = max(2, $currentPage - 1);
    $end = min($totalPages - 1, $currentPage + 1);
    for ($i = $start; $i <= $end; $i++) {
        $pages[] = $i;
    }
    if ($currentPage < $totalPages - 2) {
        $pages[] = '...';
    }
    $pages[] = $totalPages;
}
@endphp

<nav role="navigation" aria-label="Pagination" {{ $attributes->class('flex items-center gap-1') }}>
    {{-- Previous --}}
    <a
        @if($currentPage > 1) href="{{ $baseUrl }}{{ $currentPage - 1 }}" @endif
        class="{{ cx(
            'inline-flex size-10 items-center justify-center rounded-lg text-sm font-medium transition duration-100 ease-linear',
            $currentPage > 1
                ? 'text-secondary hover:bg-primary_hover cursor-pointer'
                : 'text-quaternary cursor-not-allowed pointer-events-none',
        ) }}"
        @if($currentPage <= 1) aria-disabled="true" @endif
    >
        <svg class="size-5" viewBox="0 0 20 20" fill="none">
            <path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    {{-- Page numbers --}}
    @foreach($pages as $page)
        @if($page === '...')
            <span class="inline-flex size-10 items-center justify-center text-sm text-tertiary">...</span>
        @else
            <a
                href="{{ $baseUrl }}{{ $page }}"
                class="{{ cx(
                    'inline-flex size-10 items-center justify-center rounded-lg text-sm font-medium transition duration-100 ease-linear',
                    $page === $currentPage
                        ? 'bg-active text-secondary font-semibold'
                        : 'text-tertiary hover:bg-primary_hover',
                ) }}"
                @if($page === $currentPage) aria-current="page" @endif
            >
                {{ $page }}
            </a>
        @endif
    @endforeach

    {{-- Next --}}
    <a
        @if($currentPage < $totalPages) href="{{ $baseUrl }}{{ $currentPage + 1 }}" @endif
        class="{{ cx(
            'inline-flex size-10 items-center justify-center rounded-lg text-sm font-medium transition duration-100 ease-linear',
            $currentPage < $totalPages
                ? 'text-secondary hover:bg-primary_hover cursor-pointer'
                : 'text-quaternary cursor-not-allowed pointer-events-none',
        ) }}"
        @if($currentPage >= $totalPages) aria-disabled="true" @endif
    >
        <svg class="size-5" viewBox="0 0 20 20" fill="none">
            <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
</nav>
