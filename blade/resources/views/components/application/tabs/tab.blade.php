@props([
    'name' => '',
])

<button
    type="button"
    role="tab"
    @click="activeTab = @js($name)"
    :aria-selected="activeTab === @js($name)"
    {{ $attributes->class(cx(
        'cursor-pointer whitespace-nowrap px-3 py-2 text-sm font-semibold transition duration-100 ease-linear',
    )) }}
    :class="{
        {{-- Underline styles --}}
        '-mb-px border-b-2 border-brand-solid text-brand-secondary': type === 'underline' && activeTab === @js($name),
        '-mb-px border-b-2 border-transparent text-tertiary hover:border-secondary hover:text-secondary_hover': type === 'underline' && activeTab !== @js($name),

        {{-- Button gray styles --}}
        'rounded-lg bg-active text-secondary': type === 'button-gray' && activeTab === @js($name),
        'rounded-lg text-tertiary hover:bg-primary_hover hover:text-secondary_hover': type === 'button-gray' && activeTab !== @js($name),

        {{-- Button brand styles --}}
        'rounded-lg bg-brand-solid text-white': type === 'button-brand' && activeTab === @js($name),
        'rounded-lg text-tertiary hover:bg-primary_hover hover:text-secondary_hover': type === 'button-brand' && activeTab !== @js($name),
    }"
>
    {{ $slot }}
</button>
