<?php

namespace Leonidas\Contracts\System\Taxonomy;

interface TaxonomyRegistrarInterface
{
    public function registerOne(TaxonomyInterface $taxonomy);

    public function registerMany(TaxonomyInterface ...$taxonomies);
}
