<?php

namespace Leonidas\Contracts\System\Taxonomy;

use Leonidas\Contracts\System\BaseSystemModelTypeOptionHandlerInterface;

interface TaxonomyOptionHandlerInterface extends BaseSystemModelTypeOptionHandlerInterface
{
    public function handle(TaxonomyInterface $taxonomy, $value);
}
