<?php

namespace WebContent\Copy\Contracts;

use Stringable;

interface KickerInterface extends ViewDataInterface, Stringable
{
    public function getText(): string;
}
