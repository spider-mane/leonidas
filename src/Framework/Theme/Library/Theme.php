<?php

namespace Leonidas\Framework\Theme\Library;

use Leonidas\Framework\Helpers\Theme as BaseTheme;

class Theme extends BaseTheme
{
    public static function support(array $features)
    {
        foreach ($features as $feature => $args) {

            if (is_int($feature)) {
                static::addSupport($args);
            } else {
                static::addSupport($feature, $args);
            }
        }
    }

    public static function addSupport(string $feature, $args = null)
    {
        if (isset($args)) {
            if (is_array($args) && array_is_list($args)) {
                add_theme_support($feature, ...$args);
            } else {
                add_theme_support($feature, $args);
            }
        } else {
            add_theme_support($feature);
        }
    }
}
