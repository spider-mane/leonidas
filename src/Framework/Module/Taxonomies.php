<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyFactoryInterface;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyOptionHandlerCollectionInterface;
use Leonidas\Framework\Module\Abstracts\TaxonomyRegistrationModule;
use Leonidas\Library\System\Configuration\Taxonomy\TaxonomyFactory;

class Taxonomies extends TaxonomyRegistrationModule
{
    protected function taxonomies(): array
    {
        return $this->factory()->createMany($this->getTaxonomyConfig());
    }

    protected function getTaxonomyConfig(): array
    {
        $config = $this->getConfig($this->taxonomyConfigKey());

        unset($config['@override']);

        return $config;
    }

    protected function factory(): TaxonomyFactoryInterface
    {
        return new TaxonomyFactory($this->extension->prefix('', '_'));
    }

    protected function optionHandlers(): ?TaxonomyOptionHandlerCollectionInterface
    {
        $service = $this->optionHandlerService();

        return $this->hasService($service)
            ? $this->getService($service)
            : null;
    }

    protected function taxonomyConfigKey(): string
    {
        return 'taxonomies';
    }

    protected function optionHandlerService(): string
    {
        return 'taxonomy_option_handlers';
    }
}
