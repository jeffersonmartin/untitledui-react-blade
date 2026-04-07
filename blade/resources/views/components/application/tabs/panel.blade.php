@props([
    'name' => '',
])

<div
    x-show="activeTab === @js($name)"
    x-cloak
    role="tabpanel"
    {{ $attributes }}
>
    {{ $slot }}
</div>
