<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\ModelConfigurationInterface;

interface TaxonomyInterface extends
    ModelConfigurationInterface,
    TaxonomyInfoInterface,
    TaxonomyCoreConfigInterface,
    TaxonomyPublicConfigInterface,
    TaxonomyRestConfigInterface,
    TaxonomyAdminConfigInterface
{
    //
}
