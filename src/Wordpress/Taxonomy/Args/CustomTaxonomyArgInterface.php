<?php

namespace Backalley\WordPress\Taxonomy\Args;

interface CustomTaxonomyArgInterface
{
    public static function pass($taxonomy, $args);

    public static function run();
}