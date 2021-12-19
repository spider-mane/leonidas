<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ImageSizeCollectionInterface
{
    /**
     * @return ImageSizeInterface[]
     */
    public function getSizes(): array;

    public function getSize(string $image): ImageSizeInterface;

    public function hasSize(string $image): bool;

    public function addSize(ImageSizeInterface $image);
}
