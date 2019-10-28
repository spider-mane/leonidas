<?php

namespace WebTheory\Voltaire;

class ThemeSupport
{
    /**
     *
     */
    public static function customHeader(array $defaults)
    {
        add_theme_support('custom-header', $defaults);
    }

    /**
     *
     */
    public static function html5(array $tags)
    {
        add_theme_support('html5', $tags);
    }

    /**
     *
     */
    public static function customLogo(string $defaults)
    {
        add_theme_support('custom-logo', $defaults);
    }

    /**
     *
     */
    public static function postThumbnails(string ...$postTypes)
    {
        add_theme_support('post-thumbnails', ...$postTypes);
    }
}
