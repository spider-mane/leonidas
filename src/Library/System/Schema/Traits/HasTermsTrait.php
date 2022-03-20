<?php

namespace Leonidas\Library\System\Schema\Traits;

trait HasTermsTrait
{
    protected function getTerms(string $taxonomy)
    {
        return get_terms([
            'taxonomy' => $taxonomy,
        ]);
    }

    abstract protected function getId(): int;
}
