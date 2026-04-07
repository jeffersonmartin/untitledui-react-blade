@props([
    'isInvalid' => false,
    'isRequired' => false,
    'tooltip' => null,
    'for' => null,
])

<label
    data-label="true"
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->class(cx(
        'flex cursor-default items-center gap-0.5 text-sm font-medium text-secondary',
    )) }}
>
    {{ $slot }}

    @if($isRequired)
        <span class="{{ cx('text-brand-tertiary', $isInvalid && 'text-error-primary') }}">*</span>
    @endif

    @if($tooltip)
        <x-untitledui::tooltip :title="$tooltip">
            <button type="button" class="cursor-pointer text-fg-quaternary transition duration-200 hover:text-fg-quaternary_hover focus:text-fg-quaternary_hover">
                {{-- Help circle icon --}}
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </button>
        </x-untitledui::tooltip>
    @endif
</label>
