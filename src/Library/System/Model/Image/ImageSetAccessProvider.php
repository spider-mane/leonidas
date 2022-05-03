<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\SetAccessProvider;

class ImageSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    use DatableAccessProviderTrait;

    public function __construct(ImageInterface $image)
    {
        parent::__construct($image, $this->resolvedSetters($image));
    }

    protected function resolvedSetters(ImageInterface $image): array
    {
        $setGuid = fn ($guid) => $image->setGuid(new WebPage($guid));

        return [
            'guid' => $setGuid,
        ] + $this->resolvedDatableSetters($image);
    }
}
