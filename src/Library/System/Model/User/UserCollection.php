<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\User\UserCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class UserCollection extends AbstractModelCollection implements UserCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(UserInterface ...$users)
    {
        $this->initKernel($users);
    }

    public function collect(UserInterface ...$users): void
    {
        $this->kernel->collect($users);
    }

    public function add(UserInterface $user): void
    {
        $this->kernel->insert($user);
    }

    public function hasWithId(int ...$id): bool
    {
        return $this->kernel->hasWhere('id', 'in', $id);
    }

    public function hasWith(string $property, ...$values): bool
    {
        return $this->kernel->hasWhere($property, 'in', $values);
    }

    public function hasWhere(string $property, string $operator, $value): bool
    {
        return $this->kernel->hasWhere($property, $operator, $value);
    }

    public function matches(UserCollectionInterface $users): bool
    {
        return $this->kernel->matches($users->toArray());
    }

    public function getById(int $id): ?UserInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByEmail(string $email): ?UserInterface
    {
        return $this->kernel->firstWhere('email', '=', $email);
    }

    public function getByLogin(string $login): ?UserInterface
    {
        return $this->kernel->firstWhere('login', '=', $login);
    }

    public function getByNicename(string $nicename): ?UserInterface
    {
        return $this->kernel->firstWhere('nicename', '=', $nicename);
    }

    public function getBy(string $property, $value): ?UserInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?UserInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?UserInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?UserInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): UserCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): UserCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function with(string $property, ...$values): UserCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): UserCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): UserCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): UserCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(UserCollectionInterface ...$users): UserCollection
    {
        return $this->kernel->diff(...$this->expose(...$users));
    }

    public function contrast(UserCollectionInterface ...$users): UserCollection
    {
        return $this->kernel->contrast(...$this->expose(...$users));
    }

    public function intersect(UserCollectionInterface ...$users): UserCollection
    {
        return $this->kernel->intersect(...$this->expose(...$users));
    }

    public function merge(UserCollectionInterface ...$users): UserCollection
    {
        return $this->kernel->merge(...$this->expose(...$users));
    }

    public function sortBy(string $property, string $order = 'asc'): UserCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): UserCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): UserCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
