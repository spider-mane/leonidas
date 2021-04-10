<?php

namespace Leonidas\Library\Core\Models\Taxonomy\OptionHandlers;

use Leonidas\Contracts\Options\TaxonomyOptionHandlerInterface;
use WP_Taxonomy;

class MaintainMetaboxHierarchy implements TaxonomyOptionHandlerInterface
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
    public static function handle(WP_Taxonomy $taxonomy, $arg)
    {
        if (true === $arg) {
            (new static($taxonomy))->hook();
        }
    }
}
