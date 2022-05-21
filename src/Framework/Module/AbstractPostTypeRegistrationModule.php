<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\Model\PostType\PostTypeInterface;
use Leonidas\Contracts\System\Model\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\Model\PostType\PostTypeRegistrarInterface;
use Leonidas\Hooks\TargetsInitHook;
use Leonidas\Library\System\Model\PostType\PostTypeRegistrar;

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
