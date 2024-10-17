<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\ModelConfigurationOptionHandlerInterface;

interface TaxonomyOptionHandlerInterface extends ModelConfigurationOptionHandlerInterface
{
    public function handle(TaxonomyInterface $taxonomy, $value);
}
