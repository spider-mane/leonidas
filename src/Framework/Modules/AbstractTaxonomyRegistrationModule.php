<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\Taxonomy\TaxonomyInterface;
use Leonidas\Contracts\System\Taxonomy\TaxonomyOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\Taxonomy\TaxonomyRegistrarInterface;
use Leonidas\Library\System\Taxonomy\TaxonomyRegistrar;
use Leonidas\Traits\Hooks\TargetsInitHook;

abstract class AbstractTaxonomyRegistrationModule extends AbstractModule implements ModuleInterface
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
