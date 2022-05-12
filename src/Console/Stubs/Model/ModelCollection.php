<?php

namespace Leonidas\Console\Stubs\Model;

use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class DummyModelCollection extends AbstractModelCollection implements DummyModelCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'dummy_identifier';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(DummyModelInterface ...$dummyModels)
    {
        $this->initKernel($dummyModels);
    }

    public function collect(DummyModelInterface ...$dummyModel): void
    {
        $this->kernel->collect($dummyModel);
    }

    public function add(DummyModelInterface $dummyModel): void
    {
        $this->kernel->insert($dummyModel);
    }

    public function getById(int $id): DummyModelInterface
    {
        return $this->kernel->where('id', '=', $id);
    }

    public function where(string $property, string $operator, $value): DummyModelInterface
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function hasWhere(string $property, string $operator, $value): bool
    {
        return $this->kernel->hasWhere($property, $operator, $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?DummyModelInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function remove($item): bool
    {
        return $this->kernel->remove($item);
    }

    public function hasItems(): bool
    {
        return $this->kernel->hasItems();
    }

    public function hasWithId(int $id): bool
    {
        return $this->kernel->hasWhere('id', '=', $id);
    }

    public function removeWithId(int $id): DummyModelCollectionInterface
    {
        return $this->kernel->where('id', '!=', $id);
    }

    public function matches(DummyModelCollectionInterface $dummyModelCollection): bool
    {
        return $this->kernel->matches($dummyModelCollection->toArray());
    }

    public function filter(callable $callback): DummyModelCollectionInterface
    {
        return $this->kernel->filter($callback);
    }

    public function diff(DummyModelCollectionInterface ...$collections): DummyModelCollectionInterface
    {
        return $this->kernel->diff(...$this->expose($collections));
    }

    public function contrast(DummyModelCollectionInterface ...$collections): DummyModelCollectionInterface
    {
        return $this->kernel->contrast(...$this->expose($collections));
    }

    public function intersect(DummyModelCollectionInterface ...$collections): DummyModelCollectionInterface
    {
        return $this->kernel->intersect(...$this->expose($collections));
    }

    public function merge(DummyModelCollectionInterface ...$dummyModel): DummyModelCollectionInterface
    {
        return $this->kernel->merge(...$this->expose($dummyModel));
    }

    public function extractIds(): array
    {
        return $this->kernel->column('id');
    }

    public function column(string $property): array
    {
        return $this->kernel->column($property);
    }

    public function first(): DummyModelInterface
    {
        return $this->kernel->first();
    }

    public function last(): DummyModelInterface
    {
        return $this->kernel->last();
    }

    public function sortBy(string $property, string $order = 'asc'): DummyModelCollectionInterface
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): DummyModelCollectionInterface
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback): DummyModelCollectionInterface
    {
        return $this->kernel->sortCustom($callback);
    }
}
