<?php

namespace Leonidas\Library\System\Model\Taxonomy\Traits;

use Leonidas\Library\System\Model\Traits\HasSystemModelTypeDataTrait;

trait HasTaxonomyDataTrait
{
    use HasSystemModelTypeDataTrait;

    protected array $objectTypes;

    public function getObjectTypes(): array
    {
        return $this->objectTypes;
    }
}
