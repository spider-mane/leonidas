<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\Collection\ObjectCollectionInterface;

/**
 * @template T
 * @extends ObjectCollectionInterface<T>
 */
interface ModelCollectionInterface extends ObjectCollectionInterface
{
    /**
     * @param callable(T): mixed
     */
    public function map(callable $callback): array;

    /**
     * @param callable(T): mixed
     */
    public function walk(callable $callback): void;

    /**
     * @param callable(T): mixed
     */
    public function foreach(callable $callback): void;

    public function extract(string $property): array;
}
