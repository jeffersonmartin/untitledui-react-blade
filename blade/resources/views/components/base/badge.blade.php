@props([
    'type' => 'pill-color',
    'size' => 'md',
    'color' => 'gray',
    'dot' => false,
    'iconLeading' => null,
    'iconTrailing' => null,
])

@php
// Color maps
$filledColors = [
    'gray'    => ['root' => 'bg-utility-neutral-50 text-utility-neutral-700 ring-utility-neutral-200', 'addon' => 'text-utility-neutral-500'],
    'brand'   => ['root' => 'bg-utility-brand-50 text-utility-brand-700 ring-utility-brand-200',       'addon' => 'text-utility-brand-500'],
    'error'   => ['root' => 'bg-utility-red-50 text-utility-red-700 ring-utility-red-200',             'addon' => 'text-utility-red-500'],
    'warning' => ['root' => 'bg-utility-yellow-50 text-utility-yellow-700 ring-utility-yellow-200',    'addon' => 'text-utility-yellow-500'],
    'success' => ['root' => 'bg-utility-green-50 text-utility-green-700 ring-utility-green-200',       'addon' => 'text-utility-green-500'],
    'slate'   => ['root' => 'bg-utility-slate-50 text-utility-slate-700 ring-utility-slate-200',       'addon' => 'text-utility-slate-500'],
    'sky'     => ['root' => 'bg-utility-sky-50 text-utility-sky-700 ring-utility-sky-200',             'addon' => 'text-utility-sky-500'],
    'blue'    => ['root' => 'bg-utility-blue-50 text-utility-blue-700 ring-utility-blue-200',          'addon' => 'text-utility-blue-500'],
    'indigo'  => ['root' => 'bg-utility-indigo-50 text-utility-indigo-700 ring-utility-indigo-200',    'addon' => 'text-utility-indigo-500'],
    'purple'  => ['root' => 'bg-utility-purple-50 text-utility-purple-700 ring-utility-purple-200',    'addon' => 'text-utility-purple-500'],
    'pink'    => ['root' => 'bg-utility-pink-50 text-utility-pink-700 ring-utility-pink-200',          'addon' => 'text-utility-pink-500'],
    'orange'  => ['root' => 'bg-utility-orange-50 text-utility-orange-700 ring-utility-orange-200',    'addon' => 'text-utility-orange-500'],
];

$modernColor = [
    'root' => 'bg-primary text-secondary ring-primary shadow-xs',
    'addon' => 'text-neutral-500',
];

$isPill = $type === 'pill-color';
$isModern = $type === 'modern';

$commonClasses = match($type) {
    'pill-color' => 'size-max flex items-center whitespace-nowrap rounded-full ring-1 ring-inset',
    'color'      => 'size-max flex items-center whitespace-nowrap rounded-md ring-1 ring-inset',
    'modern'     => 'size-max flex items-center whitespace-nowrap rounded-md ring-1 ring-inset shadow-xs',
};

$colorClasses = $isModern ? $modernColor : ($filledColors[$color] ?? $filledColors['gray']);

// Size classes depend on type and whether we have addons
$hasDot = $dot;
$hasIcon = $iconLeading || $iconTrailing;

if ($hasDot) {
    $sizeClasses = match(true) {
        $isPill => match($size) {
            'sm' => 'gap-1 py-0.5 pl-1.5 pr-2 text-xs font-medium',
            'md' => 'gap-1.5 py-0.5 pl-2 pr-2.5 text-sm font-medium',
            'lg' => 'gap-1.5 py-1 pl-2.5 pr-3 text-sm font-medium',
        },
        default => match($size) {
            'sm' => 'gap-1 py-0.5 px-1.5 text-xs font-medium',
            'md' => 'gap-1.5 py-0.5 px-2 text-sm font-medium',
            'lg' => 'gap-1.5 py-1 px-2.5 text-sm font-medium rounded-lg',
        },
    };
} elseif ($hasIcon) {
    $iconDir = $iconLeading ? 'leading' : 'trailing';
    $sizeClasses = match(true) {
        $isPill => match($size) {
            'sm' => $iconDir === 'leading' ? 'gap-0.5 py-0.5 pr-2 pl-1.5 text-xs font-medium' : 'gap-0.5 py-0.5 pl-2 pr-1.5 text-xs font-medium',
            'md' => $iconDir === 'leading' ? 'gap-1 py-0.5 pr-2.5 pl-2 text-sm font-medium' : 'gap-1 py-0.5 pl-2.5 pr-2 text-sm font-medium',
            'lg' => $iconDir === 'leading' ? 'gap-1 py-1 pr-3 pl-2.5 text-sm font-medium' : 'gap-1 py-1 pl-3 pr-2.5 text-sm font-medium',
        },
        default => match($size) {
            'sm' => $iconDir === 'leading' ? 'gap-0.5 py-0.5 pr-2 pl-1.5 text-xs font-medium' : 'gap-0.5 py-0.5 pl-2 pr-1.5 text-xs font-medium',
            'md' => $iconDir === 'leading' ? 'gap-1 py-0.5 pr-2 pl-1.5 text-sm font-medium' : 'gap-1 py-0.5 pl-2 pr-1.5 text-sm font-medium',
            'lg' => $iconDir === 'leading' ? 'gap-1 py-1 pr-2.5 pl-2 text-sm font-medium rounded-lg' : 'gap-1 py-1 pl-2.5 pr-2 text-sm font-medium rounded-lg',
        },
    };
} else {
    $sizeClasses = match(true) {
        $isPill => match($size) {
            'sm' => 'py-0.5 px-2 text-xs font-medium',
            'md' => 'py-0.5 px-2.5 text-sm font-medium',
            'lg' => 'py-1 px-3 text-sm font-medium',
        },
        default => match($size) {
            'sm' => 'py-0.5 px-1.5 text-xs font-medium',
            'md' => 'py-0.5 px-2 text-sm font-medium',
            'lg' => 'py-1 px-2.5 text-sm font-medium rounded-lg',
        },
    };
}
@endphp

<span {{ $attributes->class(cx($commonClasses, $sizeClasses, $colorClasses['root'])) }}>
    @if($dot)
        {{-- Dot indicator --}}
        <svg class="{{ cx($colorClasses['addon']) }}" width="8" height="8" viewBox="0 0 8 8" fill="currentColor">
            <circle cx="4" cy="4" r="3"/>
        </svg>
    @endif

    @if($iconLeading)
        {{ $iconLeading }}
    @endif

    {{ $slot }}

    @if($iconTrailing)
        {{ $iconTrailing }}
    @endif
</span>
