<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

use Closure;

trait TargetsParentFileHook
{
    protected function targetParentFileHook()
    {
        add_filter('parent_file', $this->getParentFileCallback(), null, PHP_INT_MAX);

        return $this;
    }

    protected function getParentFileCallback(): Closure
    {
        return function (string $parentFile) {
            return $this->filterParentFile($parentFile);
        };
    }

    abstract protected function filterParentFile(string $parentFile): string;
}
