<?php

namespace Leonidas\Library\System\Taxonomy\Traits;

use Leonidas\Library\System\Traits\HasSystemModelTypeDataTrait;

trait HasTaxonomyDataTrait
{
    use HasSystemModelTypeDataTrait;

    protected array $objectTypes;

    public function getObjectTypes(): array
    {
        return $this->objectTypes;
    }
}
