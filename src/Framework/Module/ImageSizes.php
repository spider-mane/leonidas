<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Ui\Asset\ImageSizeCollectionInterface;
use Leonidas\Framework\Module\Abstracts\ImageSizeProviderModule;
use Leonidas\Library\Core\Asset\ImageSize;
use Leonidas\Library\Core\Asset\ImageSizeCollection;

class ImageSizes extends ImageSizeProviderModule
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
