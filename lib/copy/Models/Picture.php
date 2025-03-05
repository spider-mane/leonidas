<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\PictureInterface;
use WebContent\Copy\Models\Abstracts\AbstractMime;

class Picture extends AbstractMime implements PictureInterface
{
    public function __construct(
        string $type,
        int|string $id,
        string $src,
        string $srcset,
        protected string $alt
    ) {
        parent::__construct($type, $id, $src, $srcset);
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + ['alt' => $this->getAlt()];
    }
}
