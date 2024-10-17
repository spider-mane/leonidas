<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\System\Configuration\PostType\PostTypeFactoryInterface;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Framework\Module\Abstracts\PostTypeRegistrationModule;
use Leonidas\Library\System\Configuration\PostType\PostTypeFactory;

class PostTypes extends PostTypeRegistrationModule
{
    protected array $postTypeData;

    protected function postTypes(): array
    {
        return $this->factory()->createMany($this->getPostTypeConfig());
    }

    protected function postTypeOverrides(): array
    {
        return $this->factory()->createMany($this->getPostTypeOverrideConfig());
    }

    protected function getPostTypeConfig(): array
    {
        $config = $this->getPostTypeData();

        unset($config['@override']);

        return $config;
    }

    protected function getPostTypeOverrideConfig(): array
    {
        $config = $this->getPostTypeData();

        return $config['@override'];
    }

    protected function getPostTypeData(): array
    {
        return $this->postTypeData ?? $this->getConfig(
            $this->postTypeConfigKey()
        );
    }

    protected function factory(): PostTypeFactoryInterface
    {
        return new PostTypeFactory($this->extension->prefix('', '_'));
    }

    protected function optionHandlers(): ?PostTypeOptionHandlerCollectionInterface
    {
        $service = $this->optionHandlerService();

        return $this->hasService($service)
            ? $this->getService($service)
            : null;
    }

    protected function postTypeConfigKey(): string
    {
        return 'post_types';
    }

    protected function optionHandlerService(): string
    {
        return 'post_type_option_handlers';
    }
}
