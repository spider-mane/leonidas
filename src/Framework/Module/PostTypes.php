<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\System\Model\PostType\PostTypeFactoryInterface;
use Leonidas\Contracts\System\Model\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Framework\Module\Abstracts\PostTypeRegistrationModule;
use Leonidas\Library\System\Model\PostType\PostTypeFactory;

class PostTypes extends PostTypeRegistrationModule
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
