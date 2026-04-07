@props([
    'title' => '',
    'description' => null,
])

<div {{ $attributes->class('flex flex-col items-center gap-4 py-12') }}>
    {{-- Icon --}}
    @if(isset($icon))
        <div>
            {{ $icon }}
        </div>
    @endif

    {{-- Text --}}
    <div class="flex flex-col items-center gap-1 text-center">
        @if($title)
            <h3 class="text-md font-semibold text-primary">{{ $title }}</h3>
        @endif

        @if($description)
            <p class="text-sm text-tertiary">{{ $description }}</p>
        @endif
    </div>

    {{-- Action --}}
    @if(isset($action))
        <div>
            {{ $action }}
        </div>
    @endif
</div>
