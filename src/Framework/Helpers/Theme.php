<?php

namespace Leonidas\Framework\Helpers;

class Theme
{
    public static function base(string $file): string
    {
        return basename($file);
    }

    public static function path(string $path): string
    {
        return get_theme_file_path($path);
    }

    public static function url(string $path): string
    {
        return get_theme_file_uri($path);
    }

    public static function data(string $theme = ''): array
    {
        $theme = (array) wp_get_theme($theme);

        return $theme["\x00WP_Theme\x00headers"];
    }
}
