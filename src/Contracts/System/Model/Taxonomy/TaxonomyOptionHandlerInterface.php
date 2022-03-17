<?php

namespace Leonidas\Contracts\System\Model\Taxonomy;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeOptionHandlerInterface;

interface TaxonomyOptionHandlerInterface extends BaseSystemModelTypeOptionHandlerInterface
{
    public function handle(TaxonomyInterface $taxonomy, $value);
}
