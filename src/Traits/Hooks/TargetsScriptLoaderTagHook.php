<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsScriptLoaderTagHook
{
    protected function targetScriptLoaderTagHook()
    {
        add_filter(
            'script_loader_tag',
            $this->getScriptLoaderTagCallback(),
            null,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getScriptLoaderTagCallback(): Closure
    {
        return function (string $tag, string $handle, string $src) {
            return $this->filterScriptLoaderTag($tag, $handle, $src);
        };
    }

    abstract protected function filterScriptLoaderTag(string $tag, string $handle, string $src): string;
}
