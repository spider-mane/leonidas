<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsWpRedirectHook
{
    protected function targetWpRedirectHook()
    {
        add_filter(
            'wp_redirect',
            $this->getWpRedirectCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpRedirectCallback(): Closure
    {
        return function (string $location, int $status) {
            return $this->filterWpRedirect($location, $status);
        };
    }

    abstract protected function filterWpRedirect(string $location, int $status): string;
}
