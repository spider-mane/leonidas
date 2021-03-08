<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;

abstract class AbstractAdminAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    public function hook(): void
    {
        $this->targetAdminEnqueueScriptsHook();
    }

    protected function targetAdminEnqueueScriptsHook()
    {
        add_action('admin_enqueue_scripts', $this->getEnqueueAdminScriptsCallback());
    }

    protected function getEnqueueAdminScriptsCallback()
    {
        return function () {
            $this->enqueueOrRegisterAdminScripts();
        };
    }

    abstract protected function enqueueOrRegisterAdminScripts(): void;
}
