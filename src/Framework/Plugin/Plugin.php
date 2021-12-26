<?php

namespace Leonidas\Framework\Plugin;

class Plugin
{
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

    public static function data(string $plugin): array
    {
        return get_plugin_data($plugin);
    }
}
