@props([
    'width' => '280px',
    'collapsible' => false,
])

<aside
    x-data="{ collapsed: false }"
    {{ $attributes->class(cx(
        'flex h-screen flex-col border-r border-secondary bg-primary',
    )) }}
    :style="{ width: collapsed ? '72px' : '{{ $width }}' }"
    style="width: {{ $width }}; transition: width 0.2s ease-in-out;"
>
    {{-- Header / Logo --}}
    @isset($header)
        <div class="flex items-center gap-2 border-b border-secondary px-5 py-5">
            {{ $header }}
        </div>
    @endisset

    {{-- Navigation items --}}
    <nav class="flex-1 overflow-y-auto px-4 py-5 scrollbar-hide">
        {{ $slot }}
    </nav>

    {{-- Footer --}}
    @isset($footer)
        <div class="border-t border-secondary px-4 py-5">
            {{ $footer }}
        </div>
    @endisset
</aside>
