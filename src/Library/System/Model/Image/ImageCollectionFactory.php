<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class ImageCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): ImageCollection
    {
        return new ImageCollection(...$entities);
    }
}
