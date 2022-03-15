<?php

namespace Leonidas\Framework\Plugin;

class Plugin
{
    public const HEADERS = [
        'name' => 'Plugin Name',
        'plugin_uri' => 'Plugin URI',
        'version' => 'Version',
        'description' => 'Description',
        'author' => 'Author',
        'author_uri' => 'Author URI',
        'textdomain' => 'Text Domain',
        'domain_path' => 'Domain Path',
        'network' => 'Network',
        'requires_wp' => 'Requires at least',
        'requires_php' => 'Requires PHP',
        'update_uri' => 'Update URI',
    ];

    public static function base(string $file): string
    {
        return plugin_basename($file);
    }

    public static function path(string $path): string
    {
        return plugin_dir_path($path);
    }

    public static function url(string $path): string
    {
        return plugin_dir_url($path);
    }

    public static function headers(string $file): array
    {
        return get_file_data($file, static::HEADERS, 'plugin');
    }

    public static function data(string $plugin): array
    {
        return get_plugin_data($plugin);
    }
}
