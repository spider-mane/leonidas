<?php

namespace Leonidas\Contracts\System\Model\Taxonomy;

interface TaxonomyRegistrarInterface
{
    public function registerOne(TaxonomyInterface $taxonomy);

    public function registerMany(TaxonomyInterface ...$taxonomies);
}
