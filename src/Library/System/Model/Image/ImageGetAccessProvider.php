<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\GetAccessProvider;

class ImageGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    use DatableAccessProviderTrait;

    public function __construct(ImageInterface $image)
    {
        parent::__construct($image, $this->resolvedGetters($image));
    }

    protected function resolvedGetters(ImageInterface $image): array
    {
        $getGuid = fn () => $image->getGuid()->getHref();

        return [
            'guid' => $getGuid,
        ] + $this->resolvedDatableGetters($image);
    }
}
