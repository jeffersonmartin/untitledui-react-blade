@props([
    'type' => 'underline',
    'defaultTab' => '',
])

@php
$tabListClasses = match($type) {
    'underline' => 'flex gap-0 border-b border-secondary',
    'button-gray', 'button-brand' => 'flex gap-1',
};
@endphp

<div
    x-data="{ activeTab: @js($defaultTab), type: @js($type) }"
    {{ $attributes->class('flex flex-col') }}
>
    {{-- Tab list --}}
    <div role="tablist" class="{{ $tabListClasses }}">
        @if(isset($tabList))
            {{ $tabList }}
        @endif
    </div>

    {{-- Tab panels --}}
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
