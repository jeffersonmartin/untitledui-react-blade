<?php

namespace UntitledUi\Blade\Components\Base;

use Illuminate\View\Component;

class Button extends Component
{
    public string $tag;
    public string $baseClasses;
    public string $sizeClasses;
    public string $colorClasses;
    public string $iconClasses;
    public bool $isIconOnly;
    public bool $isLinkType;

    public function __construct(
        public string $size = 'sm',
        public string $color = 'primary',
        public ?string $iconLeading = null,
        public ?string $iconTrailing = null,
        public bool $isDisabled = false,
        public bool $isLoading = false,
        public bool $showTextWhileLoading = false,
        public ?string $href = null,
        public string $type = 'button',
    ) {
        $this->tag = $href ? 'a' : 'button';
        $this->isLinkType = in_array($color, ['link-gray', 'link-color', 'link-destructive']);
        $this->isIconOnly = ($iconLeading || $iconTrailing) && false; // Will be set in view via slot check

        $this->baseClasses = implode(' ', [
            'group relative inline-flex h-max cursor-pointer items-center justify-center whitespace-nowrap outline-brand transition duration-100 ease-linear before:absolute focus-visible:outline-2 focus-visible:outline-offset-2',
            'disabled:cursor-not-allowed disabled:opacity-50',
        ]);

        $this->iconClasses = 'pointer-events-none size-5 shrink-0 transition-inherit-all';

        $this->sizeClasses = match ($size) {
            'xs' => 'gap-1 rounded-lg px-2.5 py-1.5 text-sm font-semibold before:rounded-[7px]',
            'sm' => 'gap-1 rounded-lg px-3 py-2 text-sm font-semibold before:rounded-[7px]',
            'md' => 'gap-1 rounded-lg px-3.5 py-2.5 text-sm font-semibold before:rounded-[7px]',
            'lg' => 'gap-1.5 rounded-lg px-4 py-2.5 text-md font-semibold before:rounded-[7px]',
            'xl' => 'gap-1.5 rounded-lg px-4.5 py-3 text-md font-semibold before:rounded-[7px]',
        };

        $this->colorClasses = match ($color) {
            'primary' => implode(' ', [
                'bg-brand-solid text-white shadow-xs-skeuomorphic ring-1 ring-transparent ring-inset hover:bg-brand-solid_hover',
                'before:absolute before:inset-px before:border before:border-white/12 before:mask-b-from-0%',
            ]),
            'secondary' => implode(' ', [
                'bg-primary text-secondary shadow-xs-skeuomorphic ring-1 ring-primary ring-inset hover:bg-primary_hover hover:text-secondary_hover',
            ]),
            'tertiary' => 'text-tertiary hover:bg-primary_hover hover:text-tertiary_hover',
            'link-color' => implode(' ', [
                'justify-normal rounded p-0! text-brand-secondary hover:text-brand-secondary_hover',
            ]),
            'link-gray' => implode(' ', [
                'justify-normal rounded p-0! text-tertiary hover:text-tertiary_hover',
            ]),
            'primary-destructive' => implode(' ', [
                'bg-error-solid text-white shadow-xs-skeuomorphic ring-1 ring-transparent outline-error ring-inset hover:bg-error-solid_hover',
                'before:absolute before:inset-px before:border before:border-white/12 before:mask-b-from-0%',
            ]),
            'secondary-destructive' => implode(' ', [
                'bg-primary text-error-primary shadow-xs-skeuomorphic ring-1 ring-error_subtle outline-error ring-inset hover:bg-error-primary hover:text-error-primary_hover',
            ]),
            'tertiary-destructive' => 'text-error-primary outline-error hover:bg-error-primary hover:text-error-primary_hover',
            'link-destructive' => 'justify-normal rounded p-0! text-error-primary outline-error hover:text-error-primary_hover',
            default => 'bg-brand-solid text-white shadow-xs-skeuomorphic ring-1 ring-transparent ring-inset hover:bg-brand-solid_hover',
        };
    }

    public function render()
    {
        return view('untitledui::components.base.button');
    }
}
