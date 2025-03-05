<?php

namespace WebContent\Copy\Contracts;

use Stringable;

interface HeadingInterface extends ViewDataInterface, Stringable
{
    public function getText(): string;
}
