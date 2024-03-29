<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsWpEnqueueScriptsHook
{
    protected function targetWpEnqueueScriptsHook()
    {
        add_action(
            "wp_enqueue_scripts",
            Closure::fromCallable([$this, 'doWpEnqueueScriptsAction']),
            $this->getWpEnqueueScriptsPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpEnqueueScriptsPriority(): int
    {
        return 10;
    }

    abstract protected function doWpEnqueueScriptsAction(): void;
}
