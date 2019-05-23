<?php

namespace Backalley\WordPress;


/**
 * @package Backalley-Core
 */
class MetaBox implements MetaBox\PostMetaFieldInterface
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
    public $post_meta_fields = [];

    use MetaBox\PostMetaFieldManagerTrait;

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
            // 'fields',
        ];

        foreach ($simple_args as $arg) {
            $method = "set_{$arg}";
            $this->$method($metabox[$arg] ?? null);
        }

        $this->set_post_meta_fields($metabox['fields']);

        $field_based_args = [
            'callback',
            'save_cb',
            'callback_args'
        ];

        foreach ($field_based_args as $arg) {
            $method = "set_{$arg}";
            $this->$method(!empty($this->post_meta_fields) ? null : $metabox[$arg] ?? null);
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
        // $this->callback = $callback ?? [$this, 'render_meta_box'];
        $this->callback = $callback ?? [$this, 'render_post_meta_fields'];
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
        // $this->save_cb = $save_cb ?? [$this, 'save_data'];
        $this->save_cb = $save_cb ?? [$this, 'save_post_meta_fields'];
        return $this;
    }

    /**
     * 
     */
    // public function set_fields($fields)
    // {
    //     $this->fields = FieldManager::bulk_creation($fields);
    //     return $this;
    // }

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
    // public function render_meta_box($post, $meta_box)
    // {
    //     FieldManager::render_all($post, $this->fields ?? []);
    //     // $this->render_fields($post);
    // }

    /**
     * Callback to save metabox data
     */
    // public function save_data($post_id, $post, $update)
    // {
    //     FieldManager::save_all($post_id, $post, $update, $this->fields ?? []);
    //     // $this->save_data($post_id, $post, $update)
    // }

    /**
     * Instantiate multiple MetaBoxes
     */
    public static function bulk_add(array $meta_boxes) : array
    {
        foreach ($meta_boxes as $name => $meta_box) {
            $meta_boxes[$name] = new MetaBox($meta_box);
        }

        return $meta_boxes;
    }
}
