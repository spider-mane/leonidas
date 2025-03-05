<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\HeadingInterface;
use WebContent\Copy\Contracts\KickerInterface;
use WebContent\Copy\Contracts\SubheadingInterface;

class Statement implements HeadingInterface, SubheadingInterface, KickerInterface
{
    public function __construct(protected string $text)
    {
        //
    }

    public function __toString(): string
    {
        return $this->getText();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function jsonSerialize(): string
    {
        return $this->getText();
    }
}
