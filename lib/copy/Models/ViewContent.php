<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\CopyInterface;
use WebContent\Copy\Contracts\ViewContentInterface;

class ViewContent implements ViewContentInterface
{
    public function __construct(
        protected CopyInterface $hero,
        protected array $sections
    ) {
        //
    }

    public function getHero(): CopyInterface
    {
        return $this->hero;
    }

    public function getSections(): array
    {
        return $this->sections;
    }

    public function jsonSerialize(): array
    {
        return [
            'hero' => $this->getHero(),
            'sections' => $this->getSections(),
        ];
    }
}
