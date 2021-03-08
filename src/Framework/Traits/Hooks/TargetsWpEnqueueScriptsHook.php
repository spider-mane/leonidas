<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

use Closure;

trait TargetsWpEnqueueScriptsHook
{
    protected function targetWpEnqueueScriptsHook(): TargetsWpEnqueueScriptsHook
    {
        add_action('wp_enqueue_scripts', $this->getWpEnqueueScriptsCallback(), null, PHP_INT_MAX);

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
