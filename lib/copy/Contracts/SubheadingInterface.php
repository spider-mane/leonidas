<?php

namespace WebContent\Copy\Contracts;

use Stringable;

interface SubheadingInterface  extends ViewDataInterface, Stringable
{
    public function getText(): string;
}
