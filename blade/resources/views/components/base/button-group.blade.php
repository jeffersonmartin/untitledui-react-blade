@props([
    'size' => 'sm',
])

@php
$sizeClasses = match($size) {
    'sm' => 'text-sm',
    'md' => 'text-md',
    'lg' => 'text-md',
};
@endphp

<div
    role="group"
    {{ $attributes->class(cx(
        'inline-flex',
        $sizeClasses,
        '[&>*]:rounded-none [&>*]:border-r-0 [&>*:first-child]:rounded-l-lg [&>*:last-child]:rounded-r-lg [&>*:last-child]:border-r',
        '[&>*]:ring-0 [&>*]:shadow-none [&>*]:ring-inset',
        '[&>*]:border [&>*]:border-secondary',
    )) }}
>
    {{ $slot }}
</div>
