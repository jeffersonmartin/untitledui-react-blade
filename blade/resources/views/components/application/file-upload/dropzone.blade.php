@props([
    'accept' => null,
    'multiple' => false,
    'name' => 'file',
])

<div
    x-data="{ dragging: false }"
    @dragover.prevent="dragging = true"
    @dragleave.prevent="dragging = false"
    @drop.prevent="
        dragging = false;
        $refs.input.files = $event.dataTransfer.files;
        $refs.input.dispatchEvent(new Event('change', { bubbles: true }));
    "
    {{ $attributes->class(cx(
        'flex flex-col items-center gap-3 rounded-xl border-2 border-dashed p-6 text-center transition duration-100 ease-linear',
    )) }}
    :class="{
        'border-brand bg-brand-primary': dragging,
        'border-secondary bg-primary': !dragging,
    }"
>
    {{-- Icon --}}
    @if(isset($icon))
        <div>
            {{ $icon }}
        </div>
    @endif

    {{-- Text --}}
    <div class="flex flex-col gap-1">
        <p class="text-sm text-tertiary">
            <button
                type="button"
                class="font-semibold text-brand-secondary hover:text-brand-secondary_hover transition duration-100 ease-linear"
                @click="$refs.input.click()"
            >Click to upload</button>
            or drag and drop
        </p>

        @if(isset($hint))
            <p class="text-xs text-tertiary">{{ $hint }}</p>
        @endif
    </div>

    {{-- Hidden file input --}}
    <input
        type="file"
        x-ref="input"
        name="{{ $name }}"
        class="sr-only"
        @if($accept) accept="{{ $accept }}" @endif
        @if($multiple) multiple @endif
    >
</div>
