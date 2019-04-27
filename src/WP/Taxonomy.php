<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WP;

class Taxonomy
{
    public function __construct($taxonomy, $args)
    {
        $this->register_taxonomy($taxonomy, $args);

        do_action("backalley/register_taxonomy/", $taxonomy, $args);
    }

    public function register_taxonomy($taxonomy, $args, $backalley_args = null)
    {
        $backalley_args = [
            'post_types',
            'maintain_mb_hierarchy',
            'structure'
        ];

        foreach ($backalley_args as $backalley_arg) {
            ${$backalley_arg} = $args['backalley_args'][$backalley_arg] ?? null;
        }

        // currently not an issue to leave it in but just in case...
        unset($args['backalley_args']);

        register_taxonomy($taxonomy, $post_types, $args);

        $this->taxonomy = get_taxonomy($taxonomy);

        // handle backalley args
        foreach (is_array($post_types) ? $post_types : [$post_types] as $post_type) {
            register_taxonomy_for_object_type($taxonomy, $post_type);
        }

        if ($maintain_mb_hierarchy === true) {
            add_filter('wp_terms_checklist_args', $this->maintain_mb_hierarchy($taxonomy), null, 2);
        }

        if (isset($structure)) {
            new Taxonomy_As_Data_Structure($this->taxonomy, $structure);
        }
    }

    public function maintain_mb_hierarchy($taxonomy)
    {
        return function ($args, $post_id) use ($taxonomy) {
            if ($args['taxonomy'] !== $taxonomy) {
                return;
            }

            $args['checked_ontop'] = false;

            return $args;
        };
    }
}
