<?php

namespace Leonidas\Framework\Theme;

class Theme
{
    public const TEMPLATE_TYPES = [
        '404', 'archive', 'attachment', 'author', 'category', 'date', 'embed',
        'frontpage', 'home', 'index', 'page', 'paged', 'privacypolicy',
        'search', 'single', 'singular', 'tag', 'taxonomy',
    ];

    public static function path(string $path = ''): string
    {
        return get_theme_file_path($path);
    }

    public static function url(string $path = ''): string
    {
        return get_theme_file_uri($path);
    }

    public static function data(string $theme = ''): array
    {
        $theme = (array) wp_get_theme($theme);

        return $theme["\x00WP_Theme\x00headers"];
    }

    public static function templateTypes()
    {
        return static::TEMPLATE_TYPES;
    }

    // public static function support(array $features)
    // {
    //     foreach ($features as $feature => $args) {

    //         if (is_int($feature)) {
    //             static::addSupport($args);
    //         } else {
    //             static::addSupport($feature, $args);
    //         }
    //     }
    // }

    // public static function addSupport(string $feature, $args = null)
    // {
    //     if (isset($args)) {
    //         if (is_array($args) && array_is_list($args)) {
    //             add_theme_support($feature, ...$args);
    //         } else {
    //             add_theme_support($feature, $args);
    //         }
    //     } else {
    //         add_theme_support($feature);
    //     }
    // }
}
