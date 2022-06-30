<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\AuthorCollectionInterface;
use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class AuthorCollection extends AbstractModelCollection implements AuthorCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(AuthorInterface ...$authors)
    {
        $this->initKernel($authors);
    }

    public function collect(AuthorInterface ...$authors): void
    {
        $this->kernel->collect($authors);
    }

    public function add(AuthorInterface $author): void
    {
        $this->kernel->insert($author);
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

    public function matches(AuthorCollectionInterface $authors): bool
    {
        return $this->kernel->matches($authors->toArray());
    }

    public function getById(int $id): ?AuthorInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByEmail(string $email): ?AuthorInterface
    {
        return $this->kernel->firstWhere('email', '=', $email);
    }

    public function getByLogin(string $login): ?AuthorInterface
    {
        return $this->kernel->firstWhere('login', '=', $login);
    }

    public function getByNicename(string $nicename): ?AuthorInterface
    {
        return $this->kernel->firstWhere('nicename', '=', $nicename);
    }

    public function getBy(string $property, $value): ?AuthorInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?AuthorInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?AuthorInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?AuthorInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): AuthorCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): AuthorCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function with(string $property, ...$values): AuthorCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): AuthorCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): AuthorCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): AuthorCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(AuthorCollectionInterface ...$authors): AuthorCollection
    {
        return $this->kernel->diff(...$this->expose(...$authors));
    }

    public function contrast(AuthorCollectionInterface ...$authors): AuthorCollection
    {
        return $this->kernel->contrast(...$this->expose(...$authors));
    }

    public function intersect(AuthorCollectionInterface ...$authors): AuthorCollection
    {
        return $this->kernel->intersect(...$this->expose(...$authors));
    }

    public function merge(AuthorCollectionInterface ...$authors): AuthorCollection
    {
        return $this->kernel->merge(...$this->expose(...$authors));
    }

    public function sortBy(string $property, string $order = 'asc'): AuthorCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): AuthorCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): AuthorCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
