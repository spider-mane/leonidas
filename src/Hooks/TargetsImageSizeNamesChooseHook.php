<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsImageSizeNamesChooseHook
{
    protected function targetImageSizeNamesChooseHook()
    {
        add_filter(
            'image_size_names_choose',
            Closure::fromCallable([$this, 'filterImageSizeNamesChoose']),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function filterImageSizeNamesChoose(array $sizeNames): array;
}
