<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyInterface;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyRegistrarInterface;
use Leonidas\Hooks\TargetsInitHook;
use Leonidas\Library\System\Configuration\Taxonomy\TaxonomyRegistrar;

abstract class TaxonomyRegistrationModule extends Module implements ModuleInterface
{
    use TargetsInitHook;

    public function hook(): void
    {
        $this->targetInitHook();
    }

    protected function doInitAction(): void
    {
        $this->registerTaxonomies();
    }

    protected function registerTaxonomies(): void
    {
        $this->taxonomyRegistrar()->registerMany(...$this->taxonomies());
    }

    protected function taxonomyRegistrar(): TaxonomyRegistrarInterface
    {
        return new TaxonomyRegistrar($this->optionHandlers());
    }

    protected function optionHandlers(): ?TaxonomyOptionHandlerCollectionInterface
    {
        return null;
    }

    /**
     * @return TaxonomyInterface[]
     */
    abstract protected function taxonomies(): array;
}
