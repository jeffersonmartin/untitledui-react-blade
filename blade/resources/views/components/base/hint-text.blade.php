@props([
    'isInvalid' => false,
    'size' => 'md',
])

<p {{ $attributes->class(cx(
    'text-sm text-tertiary',
    $size === 'sm' && 'text-xs',
    $isInvalid && 'text-error-primary',
)) }}>
    {{ $slot }}
</p>
