<?php

if (!function_exists('cx')) {
    function cx(...$classes): string
    {
        $filtered = array_filter($classes, fn($class) => is_string($class) && $class !== '');
        $merged = implode(' ', $filtered);

        if (class_exists(\TailwindMerge\TailwindMerge::class)) {
            return app(\TailwindMerge\TailwindMerge::class)->merge($merged);
        }

        return $merged;
    }
}
