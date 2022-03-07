<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\PostType\PostTypeFactoryInterface;
use Leonidas\Contracts\System\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Library\System\PostType\PostTypeFactory;

class PostTypes extends AbstractPostTypeRegistrationModule implements ModuleInterface
{
    protected function postTypes(): array
    {
        return $this->factory()->createMany($this->getPostTypeResource());
    }

    protected function getPostTypeResource(): array
    {
        return $this->getConfig($this->postTypeResourceKey());
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

    protected function postTypeResourceKey(): string
    {
        return 'post_types';
    }

    protected function optionHandlerService(): string
    {
        return 'post_type_option_handlers';
    }
}
