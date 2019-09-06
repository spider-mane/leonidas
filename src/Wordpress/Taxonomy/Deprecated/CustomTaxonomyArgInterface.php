<?php

namespace Backalley\Wordpress\Taxonomy\Deprecated;

interface CustomTaxonomyArgInterface
{
    public static function pass($taxonomy, $args);

    public static function run();
}
