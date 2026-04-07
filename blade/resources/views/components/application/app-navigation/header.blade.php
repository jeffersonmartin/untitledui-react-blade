@props([
    'sticky' => true,
])

<header
    x-data="{ mobileMenuOpen: false }"
    {{ $attributes->class(cx(
        'z-40 w-full border-b border-secondary bg-primary',
        $sticky && 'sticky top-0',
    )) }}
>
    <div class="mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        {{-- Logo --}}
        @isset($logo)
            <div class="flex shrink-0 items-center">
                {{ $logo }}
            </div>
        @endisset

        {{-- Desktop navigation --}}
        <nav class="hidden items-center gap-1 md:flex">
            {{ $slot }}
        </nav>

        {{-- Actions --}}
        @isset($actions)
            <div class="hidden items-center gap-3 md:flex">
                {{ $actions }}
            </div>
        @endisset

        {{-- Mobile menu button --}}
        <button
            type="button"
            class="flex items-center justify-center rounded-lg p-2 text-fg-quaternary transition hover:bg-primary_hover hover:text-fg-quaternary_hover md:hidden"
            @click="mobileMenuOpen = !mobileMenuOpen"
            aria-label="Toggle menu"
        >
            <svg x-show="!mobileMenuOpen" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg x-show="mobileMenuOpen" x-cloak class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        x-cloak
        class="border-t border-secondary md:hidden"
    >
        <nav class="flex flex-col gap-1 px-4 py-4">
            {{ $mobileNav ?? $slot }}
        </nav>

        @isset($actions)
            <div class="flex flex-col gap-3 border-t border-secondary px-4 py-4">
                {{ $actions }}
            </div>
        @endisset
    </div>
</header>
