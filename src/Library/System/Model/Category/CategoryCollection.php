<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class CategoryCollection extends AbstractModelCollection implements CategoryCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'slug';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(CategoryInterface ...$categories)
    {
        $this->initKernel($categories);
    }

    public function getById(int $id): ?CategoryInterface
    {
        return $this->kernel->where('id', '=', $id);
    }

    public function getBySlug(string $slug): ?CategoryInterface
    {
        return $this->kernel->fetch($slug);
    }

    public function add(CategoryInterface $category): void
    {
        $this->kernel->insert($category);
    }

    public function collect(CategoryInterface ...$categories): void
    {
        $this->kernel->collect($categories);
    }

    public function merge(CategoryCollectionInterface $categories): CategoryCollectionInterface
    {
        return $this->kernel->merge($categories->toArray());
    }

    public function containsWithId(int $id): bool
    {
        return $this->kernel->hasWhere('id', '=', $id);
    }

    public function containsWithSlug(string $slug): bool
    {
        return $this->kernel->contains('slug');
    }

    public function removeWithId(int $id): CategoryCollectionInterface
    {
        return $this->kernel->where('id', '!=', $id);
    }

    public function removeWithSlug(string $slug): CategoryCollectionInterface
    {
        return $this->kernel->where('slug', '!=', $slug);
    }

    public function matches(CategoryCollectionInterface $categories): bool
    {
        return $this->kernel->matches($categories->toArray());
    }

    public function extractIds(): array
    {
        return $this->kernel->column('id');
    }

    public function extractNames(): array
    {
        return $this->kernel->column('name');
    }

    public function extractSlugs(): array
    {
        return $this->kernel->column('slug');
    }
}
