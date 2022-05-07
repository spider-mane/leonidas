<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsAdminEnqueueScriptsHook
{
    protected function targetAdminEnqueueScriptsHook()
    {
        add_action(
            'admin_enqueue_scripts',
            $this->getAdminEnqueueScriptsCallback(),
            10,
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
