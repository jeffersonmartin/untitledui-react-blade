@props([
    'size' => 'md',
    'src' => null,
    'alt' => '',
    'initials' => null,
    'title' => '',
    'subtitle' => '',
    'status' => null,
    'verified' => false,
])

@php
$textSizes = match($size) {
    'xs'  => ['title' => 'text-xs font-semibold',  'subtitle' => 'text-xs'],
    'sm'  => ['title' => 'text-sm font-semibold',  'subtitle' => 'text-sm'],
    'md'  => ['title' => 'text-sm font-semibold',  'subtitle' => 'text-sm'],
    'lg'  => ['title' => 'text-md font-semibold',  'subtitle' => 'text-md'],
    'xl'  => ['title' => 'text-lg font-semibold',  'subtitle' => 'text-md'],
    '2xl' => ['title' => 'text-xl font-semibold',  'subtitle' => 'text-md'],
};
@endphp

<div {{ $attributes->class('inline-flex items-center gap-3') }}>
    <x-untitledui::avatar
        :size="$size"
        :src="$src"
        :alt="$alt"
        :initials="$initials"
        :status="$status"
        :verified="$verified"
    />

    <div class="flex flex-col">
        <span class="{{ cx('text-primary', $textSizes['title']) }}">{{ $title }}</span>
        @if($subtitle)
            <span class="{{ cx('text-tertiary', $textSizes['subtitle']) }}">{{ $subtitle }}</span>
        @endif
    </div>
</div>
