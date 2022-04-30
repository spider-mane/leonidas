<?php

namespace Leonidas\Contracts\Collection;

use Countable;
use JsonSerializable;
use Traversable;

interface ObjectCollectionInterface extends Traversable, Countable, JsonSerializable
{
    public function values(): array;

    public function toArray(): array;
}
