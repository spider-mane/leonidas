<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\PostType\PostTypeInterface;
use Leonidas\Contracts\System\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\PostType\PostTypeRegistrarInterface;
use Leonidas\Library\System\PostType\PostTypeRegistrar;
use Leonidas\Traits\Hooks\TargetsInitHook;

abstract class AbstractPostTypeRegistrationModule extends AbstractModule implements ModuleInterface
{
    use TargetsInitHook;

    public function hook(): void
    {
        $this->targetInitHook();
    }

    protected function doInitAction(): void
    {
        $this->registerPostTypes();
    }

    protected function registerPostTypes(): void
    {
        $this->postTypeRegistrar()->registerMany(...$this->postTypes());
    }

    protected function postTypeRegistrar(): PostTypeRegistrarInterface
    {
        return new PostTypeRegistrar($this->optionHandlers());
    }

    protected function optionHandlers(): ?PostTypeOptionHandlerCollectionInterface
    {
        return null;
    }

    /**
     * @return PostTypeInterface[]
     */
    abstract protected function postTypes(): array;
}
