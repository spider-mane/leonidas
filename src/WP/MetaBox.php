<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WP;

use Backalley\DataFields\Field;

class MetaBox
{
    /**
     * id
     * 
     * @var
     */
    public $id;

    /**
     * title
     * 
     * @var
     */
    public $title;

    /**
     * callback
     * 
     * @var
     */
    public $callback;

    /**
     * screen
     * 
     * @var
     */
    public $screen;

    /**
     * context
     * 
     * @var
     */
    public $context;

    /**
     * priority
     * 
     * @var
     */
    public $priority;

    /**
     * callback_args
     * 
     * @var
     */
    public $callback_args;

    /**
     * save_cb
     * 
     * @var
     */
    public $save_cb;

    /**
     * fields
     * 
     * @var
     */
    public $fields;

    /**
     * 
     */
    final public function __construct($metabox)
    {
        $simple_args = [
            'id',
            'title',
            'screen',
            'context',
            'priority',
            'fields',
        ];

        foreach ($simple_args as $arg) {
            $method = "set_{$arg}";
            $this->$method($metabox[$arg] ?? null);
        }

        $field_based_args = [
            'callback',
            'save_cb',
            'callback_args'
        ];

        foreach ($field_based_args as $arg) {
            $method = "set_{$arg}";
            $this->$method(!empty($this->fields) ? null : $metabox[$arg] ?? null);
        }

        $this->hook();
    }

    /**
     * 
     */
    public function set_id($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     */
    public function set_title($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * 
     */
    public function set_callback($callback)
    {
        $this->callback = $callback ?? [$this, 'render_meta_box'];
        return $this;
    }

    /**
     * 
     */
    public function set_screen($screen)
    {
        $this->screen = $screen;
        return $this;
    }

    /**
     * 
     */
    public function set_context($context)
    {
        $this->context = $context;
        return $this;
    }

    /**
     * 
     */
    public function set_priority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * 
     */
    public function set_callback_args($callback_args)
    {
        $this->callback_args = $callback_args;
        return $this;
    }

    /**
     * 
     */
    public function set_save_cb($save_cb)
    {
        $this->save_cb = $save_cb ?? [$this, 'save_data'];
        return $this;
    }

    /**
     * 
     */
    public function set_fields($fields)
    {
        foreach ($fields ?? [] as $field => $args) {
            $this->fields[$field] = Field::generate($args);
        }
        return $this;
    }

    /**
     * 
     */
    public function hook()
    {
        add_action("add_meta_boxes_{$this->screen}", [$this, 'add_meta_box']);

        if (!empty($this->save_cb)) {
            add_action("save_post_{$this->screen}", $this->save_cb, null, 3);
        }
    }

    /**
     * 
     */
    final public function add_meta_box($post)
    {
        add_meta_box($this->id, $this->title, $this->callback, $this->screen, $this->context, $this->priority, $this->callback_args);
    }

    /**
     * Render meta box using $fields property
     */
    public function render_meta_box($post, $meta_box)
    {
        Field::render_all($post, $this->fields);
    }

    /**
     * Callback to save metabox data
     */
    public function save_data($post_id, $post, $update)
    {
        Field::save_all($post_id, $post, $update, $this->fields);
    }

    /**
     * 
     */
    public static function bulk_add($meta_boxes)
    {
        foreach ($meta_boxes as $name => $meta_box) {
            $meta_box = new MetaBox($meta_box);
            $mb_objects[$name] = $meta_box;
        }

        return $mb_objects;
    }
}
