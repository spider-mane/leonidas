<?php

namespace Leonidas\Contracts\System\Model;

use Countable;
use JsonSerializable;
use Traversable;

interface SystemModelCollectionInterface extends Traversable, Countable, JsonSerializable
{
    public function map(callable $callback): array;

    public function walk(callable $callback): void;

    public function foreach(callable $callback): void;

    public function extract(string $property): array;

    public function values(): array;

    public function toArray(): array;
}
