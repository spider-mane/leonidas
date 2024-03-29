<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsStyleLoaderTagHook
{
    protected function targetStyleLoaderTagHook()
    {
        add_filter(
            'style_loader_tag',
            $this->getStyleLoaderTagCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getStyleLoaderTagCallback(): Closure
    {
        return function (string $tag, string $handle, string $href, string $media) {
            return $this->filterStyleLoaderTag($tag, $handle, $href, $media);
        };
    }

    abstract protected function filterStyleLoaderTag(string $tag, string $handle, string $href, string $media): string;
}
