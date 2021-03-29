<?php

namespace Leonidas\Framework\Helpers;

class Plugin
{
    public static function base(string $file): string
    {
        return basename($file);
    }

    public static function path(string $path): string
    {
        return plugin_dir_path($path);
    }

    public static function url(string $path): string
    {
        return plugin_dir_url($path);
    }

    public static function headers(string $plugin): array
    {
        return get_plugin_data($plugin);
    }
}
