<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface AuthorCollectionInterface extends ModelCollectionInterface
{
    public function collect(AuthorInterface ...$authors): void;

    public function add(AuthorInterface $author): void;

    public function hasWithId(int ...$id): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(AuthorCollectionInterface $authors): bool;

    public function getById(int $id): ?AuthorInterface;

    public function getByEmail(string $email): ?AuthorInterface;

    public function getByLogin(string $login): ?AuthorInterface;

    public function getByNicename(string $nicename): ?AuthorInterface;

    public function getBy(string $property, $value): ?AuthorInterface;

    public function firstWhere(string $property, string $operator, $value): ?AuthorInterface;

    public function first(): ?AuthorInterface;

    public function last(): ?AuthorInterface;

    public function withId(int ...$id): AuthorCollectionInterface;

    public function withoutId(int ...$id): AuthorCollectionInterface;

    public function with(string $property, ...$values): AuthorCollectionInterface;

    public function without(string $property, ...$values): AuthorCollectionInterface;

    public function where(string $property, string $operator, $value): AuthorCollectionInterface;

    public function filter(callable $callback): AuthorCollectionInterface;

    public function diff(AuthorCollectionInterface ...$authors): AuthorCollectionInterface;

    public function contrast(AuthorCollectionInterface ...$authors): AuthorCollectionInterface;

    public function intersect(AuthorCollectionInterface ...$authors): AuthorCollectionInterface;

    public function merge(AuthorCollectionInterface ...$authors): AuthorCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): AuthorCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): AuthorCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): AuthorCollectionInterface;
}
