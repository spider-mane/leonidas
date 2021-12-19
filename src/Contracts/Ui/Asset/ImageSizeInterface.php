<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ImageSizeInterface
{
    public function getName(): string;

    public function getLabel(): string;

    public function getWidth(): int;

    public function getHeight(): int;

    /**
     * @return bool|array
     */
    public function getCrop();
}
