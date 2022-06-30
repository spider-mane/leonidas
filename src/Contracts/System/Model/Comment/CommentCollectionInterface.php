<?php

namespace Leonidas\Contracts\System\Model\Comment;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface CommentCollectionInterface extends ModelCollectionInterface
{
    public function collect(CommentInterface ...$comments): void;

    public function add(CommentInterface $comment): void;

    public function hasWithId(int ...$id): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(CommentCollectionInterface $comments): bool;

    public function getById(int $id): ?CommentInterface;

    public function getBy(string $property, $value): ?CommentInterface;

    public function firstWhere(string $property, string $operator, $value): ?CommentInterface;

    public function first(): ?CommentInterface;

    public function last(): ?CommentInterface;

    public function withId(int ...$id): CommentCollectionInterface;

    public function withoutId(int ...$id): CommentCollectionInterface;

    public function with(string $property, ...$values): CommentCollectionInterface;

    public function without(string $property, ...$values): CommentCollectionInterface;

    public function where(string $property, string $operator, $value): CommentCollectionInterface;

    public function filter(callable $callback): CommentCollectionInterface;

    public function diff(CommentCollectionInterface ...$comments): CommentCollectionInterface;

    public function contrast(CommentCollectionInterface ...$comments): CommentCollectionInterface;

    public function intersect(CommentCollectionInterface ...$comments): CommentCollectionInterface;

    public function merge(CommentCollectionInterface ...$comments): CommentCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): CommentCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): CommentCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): CommentCollectionInterface;
}
