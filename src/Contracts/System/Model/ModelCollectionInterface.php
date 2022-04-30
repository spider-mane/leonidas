<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\Collection\ObjectCollectionInterface;

interface ModelCollectionInterface extends ObjectCollectionInterface
{
    public function map(callable $callback): array;

    public function walk(callable $callback): void;

    public function foreach(callable $callback): void;

    public function extract(string $property): array;
}
