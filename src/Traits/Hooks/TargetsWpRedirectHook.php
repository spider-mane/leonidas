<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsWpRedirectHook
{
    protected function targetWpRedirectHook()
    {
        add_filter(
            'wp_redirect',
            Closure::fromCallable([$this, 'filterWpRedirect']),
            $this->getWpRedirectPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpRedirectPriority(): int
    {
        return 10;
    }

    abstract protected function filterWpRedirect(string $location, int $status): string;
}
