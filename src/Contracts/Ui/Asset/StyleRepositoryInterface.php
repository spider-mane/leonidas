<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Ui\StyleInterface;

interface StyleRepositoryInterface
{
    public function getStyles(): array;

    public function addStyle(StyleInterface $style);
}
