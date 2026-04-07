@props([
    'selected' => false,
])

<tr {{ $attributes->class(cx(
    'border-b border-secondary transition duration-100 ease-linear hover:bg-primary_hover',
    $selected && 'bg-active',
)) }}>
    {{ $slot }}
</tr>
