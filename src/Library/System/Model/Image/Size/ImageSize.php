<?php

namespace Leonidas\Library\System\Model\Image\Size;

use Leonidas\Contracts\System\Model\Image\Size\ImageSizeInterface;

class ImageSize implements ImageSizeInterface
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
