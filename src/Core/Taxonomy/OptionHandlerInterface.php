<?php

namespace WebTheory\Leonidas\Core\Taxonomy;

interface OptionHandlerInterface
{
    /**
     * Set arguments into values needed to implement the functionality
     *
     * @param \WP_Taxonomy $taxonomy
     * @param array $args The arguments provided
     */
    public static function handle(\WP_Taxonomy $taxonomy, $args);
}
