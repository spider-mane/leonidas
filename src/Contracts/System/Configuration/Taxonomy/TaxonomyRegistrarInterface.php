<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

interface TaxonomyRegistrarInterface
{
    public function registerOne(TaxonomyInterface $taxonomy);

    public function registerMany(TaxonomyInterface ...$taxonomies);
}
