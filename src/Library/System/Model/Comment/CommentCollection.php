<?php

namespace Leonidas\Library\System\Model\Comment;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class CommentCollection extends AbstractModelCollection implements CommentCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(CommentInterface ...$comments)
    {
        $this->initKernel($comments);
    }

    public function collect(CommentInterface ...$comments): void
    {
        $this->kernel->collect($comments);
    }

    public function add(CommentInterface $comment): void
    {
        $this->kernel->insert($comment);
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

    public function matches(CommentCollectionInterface $comments): bool
    {
        return $this->kernel->matches($comments->toArray());
    }

    public function getById(int $id): ?CommentInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getBy(string $property, $value): ?CommentInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?CommentInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?CommentInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?CommentInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): CommentCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): CommentCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function with(string $property, ...$values): CommentCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): CommentCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): CommentCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): CommentCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(CommentCollectionInterface ...$comments): CommentCollection
    {
        return $this->kernel->diff(...$this->expose(...$comments));
    }

    public function contrast(CommentCollectionInterface ...$comments): CommentCollection
    {
        return $this->kernel->contrast(...$this->expose(...$comments));
    }

    public function intersect(CommentCollectionInterface ...$comments): CommentCollection
    {
        return $this->kernel->intersect(...$this->expose(...$comments));
    }

    public function merge(CommentCollectionInterface ...$comments): CommentCollection
    {
        return $this->kernel->merge(...$this->expose(...$comments));
    }

    public function sortBy(string $property, string $order = 'asc'): CommentCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): CommentCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): CommentCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
