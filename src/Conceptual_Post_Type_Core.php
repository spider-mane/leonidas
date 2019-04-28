<?php

/**
 * @package Backalley-Core
 */

namespace Backalley;

use Timber\Timber;

abstract class Conceptual_Post_Type_Core
{
    protected static $post_var = 'backalley_post_type_data';

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

        // die(var_dump(self::$post_var, static::$post_var, __class__, get_called_class(), $_POST));

        if (!filter_has_var(INPUT_POST, static::$post_var)) {
            return;
        }


        // if (is_callable(['static', 'set_datasets'])) {
        //     static::set_datasets();
        // } else {
        //     static::set_fieldsets();
        //     Self::$datasets = &Self::$fieldsets;
        // }


        $raw_data = $_POST[static::$post_var];

        // die(var_dump(static::$post_var, $raw_data));

        /**
         * call the function that is designated to handle processing each variable within the main post variable for the
         * metabox or post type. This establishes an implicit whitelist as only post variables that  correspond to a
         * save_{$variable} method will be processed
         * 
         * find a way to add more security layers to implicit whitelisting
         */
        foreach ($raw_data as $fieldset => $value) {
            $save_fieldset = "save_{$fieldset}";
            // var_dump($fieldset);

            if (is_callable(['static', $save_fieldset])) {
                // var_dump($fieldset);
                static::$save_fieldset($post_id, $post, $update, $fieldset, $raw_data[$fieldset]);
            }

            do_action("backalley/save/{$post->post_type}/{$fieldset}", $post_id, $post, $update);
        }
        // die;

        // foreach (Self::$datasets as $fieldset) {
        //     $save_fieldset = "save_{$fieldset}";

        //     if (isset($raw_data[$fieldset]) && is_callable(['static', $save_fieldset])) {
        //         static::$save_fieldset($post_id, $post, $update, $fieldset, $raw_data[$fieldset]);
        //     }
        // }
    }
}
