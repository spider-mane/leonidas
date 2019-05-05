<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WP;

class MetaBox
{
    public $args = [];
    public $labels = [];
    public $backalley_args = [];
    public $concept = '' ?? [];

    final public function __construct($metabox)
    {
        $this->add_meta_box($metabox);

        if (!empty($metabox['sanitize_cb'])) {
            $this->save_post_data($metabox['screen'], $metabox['sanitize_cb']);
        }
    }

    final public function add_meta_box($metabox)
    {
        add_action("add_meta_boxes_{$metabox['screen']}", function ($post) use ($metabox) {
            $expected_args = [
                'id',
                'title',
                'callback',
                'screen',
                'context',
                'priority',
                'callback_args',
                'sanitize_cb'
            ];

            foreach ($expected_args as $param) {
                ${$param} = $metabox[$param] ?? null;
            }

            add_meta_box($id, $title, $callback, $screen, $context, $priority, $callback_args);
        });
    }

    final public function save_post_data($post_type, $sanitize_cb)
    {
        if (is_callable($sanitize_cb)) {
            add_action("save_post_{$post_type}", $sanitize_cb, null, 3);
        }
    }

    /**
     * 
     */
    public function render_meta_boxes($meta_boxes)
    {
        // code here
    }

    /**
     * blueprint
     */
    public function render_meta_box_fieldsets($fieldsets)
    {
        $i = count($fieldsets);

        foreach ($this->fieldsets as $fieldset) {
            $i--;
            $render = "render_{$fieldset}_fieldset";

            Fieldset::$render($post);

            echo '<br>';

            if ($i > 0) {
                echo '<hr>';
            }
        }
    }

    /**
     * 
     */
    public static function bulk_add($meta_boxes)
    {
        foreach ($meta_boxes as $meta_box) {
            new MetaBox($meta_box);
        }
    }
}
