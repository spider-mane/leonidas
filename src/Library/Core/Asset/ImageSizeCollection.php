<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ImageSizeCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ImageSizeInterface;

class ImageSizeCollection implements ImageSizeCollectionInterface
{
    /**
     * @var ImageSizeInterface[]
     */
    protected array $sizes = [];

    public function __construct(ImageSizeInterface ...$sizes)
    {
        array_map([$this, 'addSize'], $sizes);
    }

    public function addSize(ImageSizeInterface $image)
    {
        $this->sizes[$image->getName()] = $image;
    }

    public function getSizes(): array
    {
        return $this->sizes;
    }

    public function getSize(string $image): ImageSizeInterface
    {
        return $this->sizes[$image];
    }

    public function hasSize(string $image): bool
    {
        return (isset($this->sizes[$image]));
    }

    public static function with(ImageSizeInterface ...$sizes): ImageSizeCollection
    {
        return new static(...$sizes);
    }
}
