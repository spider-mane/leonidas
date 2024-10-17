<?php

namespace Leonidas\Contracts\Collection;

use Countable;
use JsonSerializable;
use Traversable;

/**
 * @template T
 */
interface ObjectCollectionInterface extends Traversable, Countable, JsonSerializable
{
    public function hasItems(): bool;

    /**
     * @return list<T>
     */
    public function values(): array;

    /**
     * @return array<T>
     */
    public function toArray(): array;
}
