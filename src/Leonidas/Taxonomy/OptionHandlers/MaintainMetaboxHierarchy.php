<?php

namespace WebTheory\Leonidas\Taxonomy\OptionHandlers;

use WebTheory\Leonidas\Taxonomy\OptionHandlerInterface;

class MaintainMetaboxHierarchy implements OptionHandlerInterface
{
    /**
     *
     */
    protected $taxonomy;

    /**
     *
     */
    public function __construct($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     *
     */
    public function hook()
    {
        add_filter('wp_terms_checklist_args', [$this, 'doit'], null, 2);
    }

    /**
     *
     */
    public function doit($args, $postId)
    {
        if ($args['taxonomy'] !== $this->taxonomy->name) {
            return $args;
        }

        $args['checked_ontop'] = false;

        return $args;
    }

    /**
     *
     */
    public static function handle(\WP_Taxonomy $taxonomy, $arg)
    {
        if (true === $arg) {
            (new static($taxonomy))->hook();
        }
    }
}
