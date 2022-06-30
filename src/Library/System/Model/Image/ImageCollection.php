<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Image\ImageCollectionInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Leonidas\Library\System\Model\Image\Abstracts\AbstractImageCollection;

class ImageCollection extends AbstractImageCollection implements ImageCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(ImageInterface ...$images)
    {
        $this->initKernel($images);
    }
}
