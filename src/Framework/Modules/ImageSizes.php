<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ImageSizeCollectionInterface;
use Leonidas\Library\Core\Asset\ImageSize;
use Leonidas\Library\Core\Asset\ImageSizeCollection;

class ImageSizes extends AbstractImageSizeProviderModule implements ModuleInterface
{
    public const SIZES_CASCADE = [
        'images.sizes', 'images', 'view.images.sizes', 'view.images',
    ];

    protected function definitions(): ImageSizeCollectionInterface
    {
        $sizes = $this->configCascade(static::SIZES_CASCADE);
        $collection = new ImageSizeCollection();

        foreach ($sizes as $name => $args) {
            $collection->addSize(new ImageSize(
                $name,
                $args['label'],
                $args['width'],
                $args['height'],
                $args['crop'] ?? false
            ));
        }

        return $collection;
    }
}
