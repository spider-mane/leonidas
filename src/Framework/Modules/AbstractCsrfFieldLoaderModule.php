<?php

namespace WebTheory\Leonidas\Framework\Modules;

use Closure;
use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;

abstract class AbstractCsrfFieldLoaderModule extends AbstractModule implements ModuleInterface
{
    public function hook(): void
    {
        $this->targetHook();
    }

    protected function targetHook(): AbstractCsrfFieldLoaderModule
    {
        add_action('', $this->getCallback());

        return $this;
    }

    protected function getCallback(): Closure
    {
        return function () {
            $this->doAction();
        };
    }

    abstract protected function doAction(): void;
}
