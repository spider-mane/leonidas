<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsScriptLoaderTagHook
{
    protected function targetScriptLoaderTagHook()
    {
        add_filter(
            'script_loader_tag',
            Closure::fromCallable([$this, 'filterScriptLoaderTag']),
            $this->getScriptLoaderTagPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getScriptLoaderTagPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function filterScriptLoaderTag(string $tag, string $handle, string $src): string;
}
