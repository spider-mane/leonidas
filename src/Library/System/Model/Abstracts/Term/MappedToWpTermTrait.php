<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

use WP_Term;

trait MappedToWpTermTrait
{
    protected WP_Term $term;

    protected function mirror(string $local, $localVal, string $mapped, $mappedVal): void
    {
        $this->{$local} = $localVal;
        $this->term->{$mapped} = $mappedVal;
    }
}
