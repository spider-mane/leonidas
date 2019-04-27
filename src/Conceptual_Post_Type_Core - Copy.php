<?php

/**
 *
 */

// namespace Backalley;

use Timber\Timber;

class Conceptual_Post_Type_Core
{
    protected static $post_var = '';

    protected static $fieldsets = [];

    protected static $datasets = [];

    protected static $blacklist = [];

    protected static $meta_boxes = [];

    /**
     * 
     */
    final public static function method_ban($trait)
    {
        Self::$blacklist[] = "render{$trait}";
    }

    /**
     * 
     */
    final public static function free_meth($trait)
    {
        unset(Self::$blacklist[$trait]);
    }

    /**
     * 
     */
    public static function super_set_meta_boxes($callback)
    {
        static::set_meta_boxes();
        Self::$meta_boxes = function () {
            $callback();
        };
        // Self::$meta_boxes = $meta_boxes;
    }

    /**
     *
     */
    final public static function load_render_functions()
    {
        if (is_callable(['static', 'set_fieldsets'])) {
            static::set_fieldsets();
        } else {
            static::set_datasets();
            Self::$fieldsets = &Self::$datasets;
        }
    }

    /**
     *
     */
    final public static function load_save_functions($post_id, $post, $update)
    {
        static::set_post_var();

        if (!filter_has_var(INPUT_POST, Self::$post_var)) {
            return;
        }


        if (is_callable(['static', 'set_datasets'])) {
            static::set_datasets();
        } else {
            static::set_fieldsets();
            Self::$datasets = &Self::$fieldsets;
        }


        $raw_data = $_POST[Self::$post_var];


        foreach (Self::$datasets as $fieldset) {
            $save_fieldset = "save_{$fieldset}";

            if (isset($raw_data[$fieldset]) && is_callable(['static', $save_fieldset])) {
                static::$save_fieldset($post_id, $post, $update, $fieldset, $raw_data[$fieldset]);
            }
        }
    }
}
