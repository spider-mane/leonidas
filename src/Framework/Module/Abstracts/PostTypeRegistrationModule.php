<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeInterface;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeRegistrarInterface;
use Leonidas\Hooks\TargetsInitHook;
use Leonidas\Library\System\Configuration\PostType\PostTypeRegistrar;

abstract class PostTypeRegistrationModule extends Module implements ModuleInterface
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
