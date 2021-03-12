<?php

namespace Leonidas\Framework\Helpers;

class SkyHooks
{
    /**
     *
     */
    protected static $tags = [];

    /**
     *
     */
    public static function collect()
    {
        add_action('all', [static::class, '_collect']);
    }

    /**
     *
     */
    public static function _collect($tag)
    {
        if (!in_array($tag, static::$tags)) {
            static::$tags[] = $tag;
        };
    }

    /**
     *
     */
    public static function dump()
    {
        add_action('shutdown', [static::class, '_dump']);
    }

    /**
     *
     */
    public static function _dump()
    {
        exit(var_dump(static::$tags));
    }

    /**
     *
     */
    public static function drop()
    {
        return static::$tags;
    }
}
