<?php

namespace Leonidas\Contracts\Ui\Asset;

interface StylePrinterInterface
{
    public function print(StyleInterface $style): string;

    public function merge(string $tag, StyleInterface $style): string;
}
