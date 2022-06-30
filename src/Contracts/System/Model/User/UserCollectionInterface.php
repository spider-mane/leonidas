<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface UserCollectionInterface extends ModelCollectionInterface
{
    public function collect(UserInterface ...$users): void;

    public function add(UserInterface $user): void;

    public function hasWithId(int ...$id): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(UserCollectionInterface $users): bool;

    public function getById(int $id): ?UserInterface;

    public function getByEmail(string $email): ?UserInterface;

    public function getByLogin(string $login): ?UserInterface;

    public function getByNicename(string $nicename): ?UserInterface;

    public function getBy(string $property, $value): ?UserInterface;

    public function firstWhere(string $property, string $operator, $value): ?UserInterface;

    public function first(): ?UserInterface;

    public function last(): ?UserInterface;

    public function withId(int ...$id): UserCollectionInterface;

    public function withoutId(int ...$id): UserCollectionInterface;

    public function with(string $property, ...$values): UserCollectionInterface;

    public function without(string $property, ...$values): UserCollectionInterface;

    public function where(string $property, string $operator, $value): UserCollectionInterface;

    public function filter(callable $callback): UserCollectionInterface;

    public function diff(UserCollectionInterface ...$users): UserCollectionInterface;

    public function contrast(UserCollectionInterface ...$users): UserCollectionInterface;

    public function intersect(UserCollectionInterface ...$users): UserCollectionInterface;

    public function merge(UserCollectionInterface ...$users): UserCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): UserCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): UserCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): UserCollectionInterface;
}
