@props([])

<div {{ $attributes->class('overflow-x-auto') }}>
    <table class="min-w-full divide-y divide-secondary">
        {{ $slot }}
    </table>
</div>
