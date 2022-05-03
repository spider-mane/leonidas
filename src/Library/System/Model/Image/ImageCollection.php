<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Image\ImageCollectionInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Leonidas\Library\System\Model\Image\Abstracts\AbstractImageCollection;

class ImageCollection extends AbstractImageCollection implements ImageCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'name';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(ImageInterface ...$images)
    {
        $this->initKernel($images);
    }

    public function getByName(string $name): ?ImageInterface
    {
        return $this->kernel->fetch($name);
    }

    public function hasWithName(string $name): bool
    {
        return $this->kernel->contains($name);
    }
}
