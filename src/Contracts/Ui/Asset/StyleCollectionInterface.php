<?php

namespace Leonidas\Contracts\Ui\Asset;

interface StyleCollectionInterface
{
    /**
     * @return StyleInterface[]
     */
    public function getStyles(): array;

    public function getStyle(string $style): StyleInterface;

    public function hasStyle(string $style): bool;

    public function addStyle(StyleInterface $style);
}
