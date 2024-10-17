<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\ModelPublicConfigInterface;

interface TaxonomyPublicConfigInterface extends ModelPublicConfigInterface
{
    public function isAllowedInTagCloud(): ?bool;
}
