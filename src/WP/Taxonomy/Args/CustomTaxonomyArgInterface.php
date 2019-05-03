<?php

namespace Backalley\WP\Taxonomy\Args;

interface CustomTaxonomyArgInterface
{
    public static function pass($taxonomy, $args);
}