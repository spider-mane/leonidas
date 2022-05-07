<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsXRedirectByHook
{
    protected function targetXRedirectByHook()
    {
        add_filter(
            'x_redirect_by',
            Closure::fromCallable([$this, 'filterXRedirectBy']),
            $this->getXRedirectByPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getXRedirectByPriority(): int
    {
        return 10;
    }

    abstract protected function filterXRedirectBy(string $xRedirectBy, int $status, string $location): string;
}
