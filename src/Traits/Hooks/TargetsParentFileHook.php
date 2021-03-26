<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsParentFileHook
{
    protected function targetParentFileHook(): TargetsParentFileHook
    {
        add_filter(
            'parent_file',
            $this->getParentFileCallback(),
            null,
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
