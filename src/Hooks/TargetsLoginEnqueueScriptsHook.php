<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsLoginEnqueueScriptsHook
{
    protected function targetLoginEnqueueScriptsHook()
    {
        add_action(
            'login_enqueue_scripts',
            $this->getLoginEnqueueScriptsCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getLoginEnqueueScriptsCallback(): Closure
    {
        return function () {
            $this->doLoginEnqueueScriptsAction();
        };
    }

    abstract protected function doLoginEnqueueScriptsAction(): void;
}
