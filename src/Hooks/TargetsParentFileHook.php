<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsParentFileHook
{
    protected function targetParentFileHook()
    {
        add_filter(
            'parent_file',
            $this->getParentFileCallback(),
            10,
            PHP_INT_MAX
        );

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
