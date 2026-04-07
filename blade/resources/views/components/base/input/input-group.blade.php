@props([
    'label' => null,
    'hint' => null,
    'isRequired' => false,
    'isInvalid' => false,
])

<div {{ $attributes->class('flex flex-col gap-1.5') }}>
    @if($label)
        <x-untitledui::label :isRequired="$isRequired" :isInvalid="$isInvalid">
            {{ $label }}
        </x-untitledui::label>
    @endif

    <div class="{{ cx(
        'flex items-stretch rounded-lg shadow-xs ring-1 ring-inset transition duration-100 ease-linear',
        $isInvalid ? 'ring-error focus-within:ring-2 focus-within:ring-error' : 'ring-primary focus-within:ring-2 focus-within:ring-brand',
    ) }}">
        {{-- Leading addon --}}
        @if(isset($leadingAddon) && $leadingAddon->isNotEmpty())
            <div class="flex items-center border-r border-secondary bg-secondary px-3 text-sm text-tertiary first:rounded-l-lg">
                {{ $leadingAddon }}
            </div>
        @endif

        {{-- Default slot (input) --}}
        <div class="flex min-w-0 flex-1 items-center">
            {{ $slot }}
        </div>

        {{-- Trailing addon --}}
        @if(isset($trailingAddon) && $trailingAddon->isNotEmpty())
            <div class="flex items-center border-l border-secondary last:rounded-r-lg">
                {{ $trailingAddon }}
            </div>
        @endif
    </div>

    @if($hint)
        <x-untitledui::hint-text :isInvalid="$isInvalid">
            {{ $hint }}
        </x-untitledui::hint-text>
    @endif
</div>
