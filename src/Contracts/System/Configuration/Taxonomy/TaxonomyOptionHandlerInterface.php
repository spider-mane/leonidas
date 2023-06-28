<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeOptionHandlerInterface;

interface TaxonomyOptionHandlerInterface extends BaseSystemModelTypeOptionHandlerInterface
{
    public function handle(TaxonomyInterface $taxonomy, $value);
}
