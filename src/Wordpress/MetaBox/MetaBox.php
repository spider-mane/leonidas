<?php

namespace Backalley\WordPress\MetaBox;


/**
 * @package Backalley-Core
 */
class MetaBox implements PostMetaFieldInterface
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

    /**
     * content
     *
     * @var array
     */
    protected $content = [];

    use PostMetaFieldManagerTrait;

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
    public function setCallback($callback)
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
     *
     */
    public function render($post, $meta_box)
    {
        $i = count($this->content);

        foreach ($this->content as $field) {
            $i--;

            $field->render($post);

            do_action("backalley/{$post->post_type}/meta_box/{$this->id}/{$field->name}", $post, $meta_box);

            echo '<br>';

            if ($i > 0) {
                echo '<hr>';
            }
        }
    }

    /**
     * Instantiate multiple MetaBoxes
     */
    public static function create(array $metaboxes) : array
    {
        foreach ($metaboxes as $name => $meta_box) {

            if (!isset($meta_box['id'])) {
                $meta_box['id'] = $name;
            }

            $metaboxes[$name] = new static($meta_box);
        }

        return $metaboxes;
    }

    /**
     * Get content
     *
     * @return  array
     */
    public function getContent($slug = null)
    {
        return isset($slug) ? $this->content[$slug] : $this->content;
    }

    /**
     *
     */
    public function addContent(string $slug, MetaboxContent $content)
    {
        $this->content[$slug] = $content;
    }

    /**
     *
     */
    public function setContent(array $content)
    {
        foreach ($content as $name => $thing) {
            $this->addContent($name, $thing);
        }
    }
}
