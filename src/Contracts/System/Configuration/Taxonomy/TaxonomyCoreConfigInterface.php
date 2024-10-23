<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\ModelCoreConfigInterface;

interface TaxonomyCoreConfigInterface extends ModelCoreConfigInterface
{
    public function getObjectTypes(): ?array;

    public function getUpdateCountCallback(): ?callable;

    public function getDefaultTerm(): null|string|array;

    public function shouldBeSorted(): ?bool;

    public function getArgs(): ?array;
}
