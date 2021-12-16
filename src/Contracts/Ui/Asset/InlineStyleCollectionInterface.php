<?php

namespace Leonidas\Contracts\Ui\Asset;

interface InlineStyleCollectionInterface
{
    /**
     * @return InlineStyleInterface[]
     */
    public function getStyles(): array;

    public function getStyle(string $style): InlineStyleInterface;

    public function hasStyle(string $style): bool;
}
