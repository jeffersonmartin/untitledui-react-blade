<?php

namespace UntitledUi\Blade;

use Illuminate\Support\ServiceProvider;

class UntitledUiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'untitledui');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/untitledui'),
        ], 'untitledui-views');

        $this->publishes([
            __DIR__.'/../css' => public_path('vendor/untitledui'),
        ], 'untitledui-assets');

        $this->publishes([
            __DIR__.'/../js' => public_path('vendor/untitledui'),
        ], 'untitledui-assets');
    }

    public function register(): void
    {
        require_once __DIR__.'/helpers.php';
    }
}
