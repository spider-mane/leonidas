<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsSubmenuFileHook
{
    protected function targetSubmenuFileHook()
    {
        add_filter(
            'submenu_file',
            $this->getSubmenuFileCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getSubmenuFileCallback(): Closure
    {
        return function (string $submenuFile, string $parentFile) {
            return $this->filterSubmenuFile($submenuFile, $parentFile);
        };
    }

    abstract protected function filterSubmenuFile(string $submenuFile, string $parentFile): string;
}
