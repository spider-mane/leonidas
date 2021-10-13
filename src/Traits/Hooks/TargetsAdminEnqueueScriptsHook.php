<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsAdminEnqueueScriptsHook
{
    protected function targetAdminEnqueueScriptsHook()
    {
        add_action(
            'admin_enqueue_scripts',
            $this->getAdminEnqueueScriptsCallback(),
            null,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAdminEnqueueScriptsCallback(): Closure
    {
        return function (string $hookSuffix) {
            $this->doAdminEnqueueScriptsAction($hookSuffix);
        };
    }

    abstract protected function doAdminEnqueueScriptsAction(string $hookSuffix): void;
}
