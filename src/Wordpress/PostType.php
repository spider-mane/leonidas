<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress;


class PostType extends ApiBase
{
    /**
     * 
     */
    public $post_type;

    /**
     * 
     */
    public $base_args;

    /**
     * 
     */
    public $post_type_object;

    /**
     * 
     */
    private static $registered = [];

    use PostType\Args\CustomArgFactoryTrait;

    final public function __construct($post_type, $args)
    {
        $this->set_post_type($post_type);
        $this->set_base_args($args);
        $this->set_custom_args($args);
        $this->register_post_type();

        if (!empty($this->custom_args)) {
            $this->custom_arg_factory();
        }
    }

    /**
     * 
     */
    public function set_post_type(string $post_type)
    {
        $this->post_type = $post_type;
    }

    /**
     * 
     */
    public function set_base_args($args)
    {
        unset($args['backalley_custom_args']);
        $this->base_args = $args;
    }

    /**
     * 
     */
    public function set_custom_args($args)
    {
        $this->custom_args = $args['backalley_custom_args'] ?? null;
    }

    /**
     * 
     */
    public function set_labels($value, $label = null)
    {
        if ($label) {
            $this->labels[$label] = $value;
        } else {
            $this->labels = (array)$value;
        }
    }

    /**
     * 
     */
    final public function register_post_type()
    {
        register_post_type($this->post_type, $this->base_args, 0);
        $this->post_type_object = get_post_type_object($this->post_type);
    }


    /**
     * 
     */
    public static function get_registered()
    {
        return Self::$registered;
    }

    /**
     * Callback to be provided to 
     */
    public static function unregistered()
    {

    }

    /**
     * 
     */
    public static function create($post_types = [])
    {
        foreach ($post_types as $post_type => $args) {

            $args['labels'] = static::build_labels($args);

            $post_types[$post_type] = new static($post_type, $args);
        }

        return $post_types;
    }

    /**
     * 
     */
    protected static function build_labels($args)
    {
        $plural = $args['labels']['name'] ?? $args['label'];
        $single = $args['labels']['singular_name'] ?? $plural;

        $hierarchical = (bool)$args['hierarchical'] ?? false;

        $default_labels = static::create_labels($single, $plural, $hierarchical);

        return $args['labels'] + $default_labels;
    }

    /**
     * 
     */
    public static function create_labels(string $single, string $plural, bool $hierarchical = false)
    {
        $single_lower = strtolower($single);
        $plural_lower = strtolower($plural);

        $labels = [
            'name' => $plural,
            'singular_name' => $single,
            'add_new_item' => "Add New {$single}",
            'edit_item' => "Edit {$single}",
            'new_item' => "New {$single}",
            'view_item' => "View {$single}",
            'view_items' => "View {$plural}",
            'search_items' => "Search {$plural}",
            'not_found' => "No {$plural_lower} found",
            'not_found_in_trash' => "No {$plural_lower} found in Trash",
            'parent_item_colon' => "Parent {$single}:",
            'all_items' => "All {$plural}",
            'archives' => "{$single} Archives",
            'attributes' => "{$single} Attributes",
            'insert_into_item' => "Insert into {$single_lower}",
            'uploaded_to_this_item' => "Uploaded to this {$single_lower}",
            'filter_items_list' => "Filter {$plural_lower} list",
            'items_list_navigation' => "{$plural} list navigation",
            'items_list' => "{$plural} list",
            'item_published' => "{$single} published",
            'item_published_privately' => "{$single} published privately",
            'item_reverted_to_draft' => "{$single} reverted to draft",
            'item_scheduled' => "{$single} scheduled",
            'item_updated' => "{$single} updated",
        ];

        return $labels;
    }
}
