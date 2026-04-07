@props([
    'minimal' => false,
])

@if($minimal)
    {{-- Minimal logo mark --}}
    <svg {{ $attributes->merge(['class' => 'h-8 w-8']) }} viewBox="0 0 32 32" fill="none">
        <rect width="32" height="32" rx="8" fill="var(--color-bg-brand-solid)" />
        <path d="M9.5 14.5L16 8L22.5 14.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M9.5 20.5L16 14L22.5 20.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.5" />
    </svg>
@else
    {{-- Full logo with wordmark --}}
    <div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
        <svg class="h-8 w-8 shrink-0" viewBox="0 0 32 32" fill="none">
            <rect width="32" height="32" rx="8" fill="var(--color-bg-brand-solid)" />
            <path d="M9.5 14.5L16 8L22.5 14.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M9.5 20.5L16 14L22.5 20.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.5" />
        </svg>
        <span class="text-xl font-semibold text-primary">Untitled UI</span>
    </div>
@endif
