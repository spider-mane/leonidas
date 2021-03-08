<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;

abstract class AbstractCsrfFieldLoaderModule extends AbstractModule implements ModuleInterface
{
    protected function targetHook()
    {
        add_action('tag', $this->getHookCallback());
    }

    protected function getHookCallback()
    {
        return function () {
            $this->renderCsrfFields();
        };
    }

    abstract protected function renderCsrfFields(): void;
}
