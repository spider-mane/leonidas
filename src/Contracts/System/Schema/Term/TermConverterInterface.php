<?php

namespace Leonidas\Contracts\System\Schema\Term;

use WP_Term;

interface TermConverterInterface
{
    public function convert(WP_Term $term): object;

    public function revert(object $entity): WP_Term;
}
