<?php

namespace Leonidas\Framework\Theme;

class Theme
{
    public const TEMPLATE_TYPES = [
        '404', 'archive', 'attachment', 'author', 'category', 'date', 'embed',
        'frontpage', 'home', 'index', 'page', 'paged', 'privacypolicy',
        'search', 'single', 'singular', 'tag', 'taxonomy',
    ];

    public const HEADERS = [
        'name' => 'Name',
        'uri' => 'ThemeURI',
        'description' => 'Description',
        'author' => 'Author',
        'author_uri' => 'AuthorURI',
        'version' => 'Version',
        'template' => 'Template',
        'status' => 'Status',
        'tags' => 'Tags',
        'title' => 'Name',
        'author_name' => 'Author',
    ];

    public static function path(string $path = ''): string
    {
        return get_theme_file_path($path);
    }

    public static function url(string $path = ''): string
    {
        return get_theme_file_uri($path);
    }

    public static function headers(string $file)
    {
        return get_file_data($file, static::HEADERS, 'theme');
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
}
