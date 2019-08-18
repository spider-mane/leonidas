<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress\Taxonomy;

use Backalley\WordPress\Taxonomy\Args\CustomTaxonomyArgFactoryTrait;

class Taxonomy
{
    use CustomTaxonomyArgFactoryTrait;

    /**
     *
     */
    public $post_types;

    /**
     *
     */
    public $base_args;

    /**
     *
     */
    public $taxonomy;

    /**
     *
     */
    public $taxonomy_object;

    /**
     *
     */
    public function __construct($taxonomy, $args, $post_types = null)
    {
        $this
            ->set_taxonomy($taxonomy)
            ->set_base_args($args)
            ->set_custom_args($args)
            ->set_post_types($post_types)
            ->register_taxonomy();

        if (!empty($this->custom_args)) {
            $this->custom_arg_factory();
        }
    }

    /**
     *
     */
    public function set_taxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;

        return $this;
    }

    /**
     *
     */
    public function set_base_args($args)
    {
        unset($args['backalley_custom_args']);
        $this->base_args = $args;

        return $this;
    }

    /**
     *
     */
    public function set_custom_args($custom_args)
    {
        $this->custom_args = $custom_args['backalley_custom_args'] ?? null;

        return $this;
    }

    /**
     *
     */
    public function set_post_types($post_types = null)
    {
        $post_types = $post_types ?? $this->custom_args['post_types'] ?? null;

        $this->post_types = is_array($post_types) ? $post_types : [$post_types];

        return $this;
    }

    /**
     *
     */
    public function register_taxonomy()
    {
        register_taxonomy($this->taxonomy, $this->post_types, $this->base_args);
        $this->taxonomy_object = get_taxonomy($this->taxonomy);

        return $this;
    }

    /**
     * pair taxonomy to provided post types
     */
    public function handle_post_types_arg($arg)
    {
        $post_types = is_array($this->post_types) ? $this->post_types : [$this->post_types];

        foreach ($post_types as $post_type) {
            register_taxonomy_for_object_type($this->taxonomy, $post_type);
        }
    }

    /**
     * Disables the default feature "checked on top" of the default hierarchical terms meta box
     */
    public function handle_maintain_mb_hierarchy_arg($arg)
    {
        if ($arg !== true) {
            return;
        }

        add_filter('wp_terms_checklist_args', function ($args, $post_id) {
            if ($args['taxonomy'] !== $this->taxonomy) {
                return;
            }

            $args['checked_ontop'] = false;

            return $args;
        }, null, 2);
    }

    /**
     * Register an array of taxonomies
     */
    public static function create($taxonomies)
    {
        foreach ($taxonomies as $taxonomy => $args) {

            $args['labels'] = static::build_labels($args);

            $taxonomies[$taxonomy] = new static($taxonomy, $args, $args['post_types'] ?? null);
        }

        return $taxonomies;
    }

    /**
     *
     */
    protected static function build_labels($args)
    {
        $plural = $args['labels']['name'] ?? $args['label'];
        $single = $args['labels']['singular_name'] ?? $plural;

        $hierarchical = (bool) $args['hierarchical'] ?? false;

        $default_labels = static::create_labels($single, $plural, $hierarchical);

        return $args['labels'] + $default_labels;
    }

    /**
     *
     */
    public static function create_labels(string $single, string $plural, bool $hierarchical = false)
    {
        $plural_lower = strtolower($plural);

        $labels = [
            'name' => $plural,
            'singular_name' => $single,
            'search_items' => "Search {$plural}",
            'popular_items' => "Popular {$plural}",
            'all_items' => "All {$plural}",
            'parent_item' => "Parent {$single}",
            'parent_item_colon' => "Parent {$single}:",
            'edit_item' => "Edit {$single}",
            'view_item' => "View {$single}",
            'update_item' => "Update {$plural}",
            'add_new_item' => "Add New {$single}",
            'new_item_name' => "New {$single} Name",
            'separate_items_with_commas' => "Separate {$plural_lower} with commas",
            'add_or_remove_items' => "Add or remove {$plural_lower}",
            'choose_from_most_used' => "Choose from the most used {$plural_lower}",
            'not_found' => "No {$plural_lower} found",
            'no_terms' => "No {$plural_lower}",
            'items_list_navigation' => "{$plural} list navigation",
            'items_list' => "{$plural} list",
            'back_to_items' => "&larr; Back to {$plural}"
        ];

        return $labels;
    }
}
