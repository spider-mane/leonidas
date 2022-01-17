<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsWpEnqueueScriptsHook
{
    protected function targetWpEnqueueScriptsHook()
    {
        add_action(
            'wp_enqueue_scripts',
            $this->getWpEnqueueScriptsCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpEnqueueScriptsCallback(): Closure
    {
        return function () {
            $this->doWpEnqueueScriptsAction();
        };
    }

    abstract protected function doWpEnqueueScriptsAction(): void;
}
