<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WP;


class Taxonomy extends CustomTaxonomyArgFactory
{
    public $post_types;
    public $base_args;
    public $taxonomy;
    public $custom_args;
    public $taxonomy_object;


    public function __construct($taxonomy, $args, $post_types = null)
    {
        $this->set_taxonomy($taxonomy);
        $this->set_base_args($args);
        $this->set_custom_args($args);
        $this->set_post_types($post_types);
        $this->register_taxonomy();
        $this->custom_args();
    }

    /**
     * 
     */
    public function set_taxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;

    }

    /**
     * 
     */
    public function set_base_args($args)
    {
        unset($args['backalley_args']);
        $this->base_args = $args;
    }

    /**
     * 
     */
    public function set_custom_args($custom_args)
    {
        $this->custom_args = $custom_args['backalley_args'];
    }

    /**
     * 
     */
    public function set_post_types($post_types = null)
    {
        $this->post_types = $post_types ?? $this->custom_args['post_types'] ?? null;
    }

    /**
     * 
     */
    public function register_taxonomy()
    {
        register_taxonomy($this->taxonomy, $this->post_types, $this->base_args);
        $this->taxonomy_object = get_taxonomy($this->taxonomy);
    }

    /**
     * pair taxonomy to provided post types
     */
    public function post_types($arg)
    {
        $post_types = is_array($this->post_types) ? $this->post_types : [$this->post_types];

        foreach ($post_types as $post_type) {
            register_taxonomy_for_object_type($this->taxonomy, $post_type);
        }
    }

    /**
     * 
     */
    public function maintain_mb_hierarchy($arg)
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
     * 
     */
    public static function bulk_registration($taxonomies)
    {
        foreach ($taxonomies as $taxonomy => $args) {
            $taxonomy = new Taxonomy($taxonomy, $args, $args['post_types'] ?? null);
        }
    }
}
