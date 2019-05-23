<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress;


class Taxonomy
{
    public $post_types;
    public $base_args;
    public $taxonomy;
    public $taxonomy_object;

    use Taxonomy\Args\CustomTaxonomyArgFactoryTrait;

    public function __construct($taxonomy, $args, $post_types = null)
    {
        $this->set_taxonomy($taxonomy);
        $this->set_base_args($args);
        $this->set_custom_args($args);
        $this->set_post_types($post_types);
        $this->register_taxonomy();

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
    public static function bulk_registration($taxonomies)
    {
        foreach ($taxonomies as $taxonomy => $args) {
            $taxonomy = new Taxonomy($taxonomy, $args, $args['post_types'] ?? null);
        }
    }
}
