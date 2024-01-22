<?php

namespace Leonidas\Framework\App\Module;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyFactoryInterface;
use Leonidas\Framework\Module\Taxonomies as TaxonomyModule;
use Leonidas\Library\System\Configuration\Taxonomy\TaxonomyFactory;

class Taxonomies extends TaxonomyModule
{
    protected function factory(): TaxonomyFactoryInterface
    {
        return new TaxonomyFactory();
    }
}
