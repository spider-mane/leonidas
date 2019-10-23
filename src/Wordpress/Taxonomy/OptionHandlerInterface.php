<?php

namespace Backalley\WordPress\Taxonomy;

interface OptionHandlerInterface
{
    /**
     * Set the args to into values need by the functionality
     *
     * @param \WP_Taxonomy $taxonomy
     * @param array $args The arguments provided
     */
    public static function handle(\WP_Taxonomy $taxonomy, $args);
}
