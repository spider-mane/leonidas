<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class TagCollection extends AbstractModelCollection implements TagCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'slug';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(TagInterface ...$tags)
    {
        $this->initKernel($tags);
    }

    public function getById(int $id): TagInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getBySlug(string $slug): TagInterface
    {
        return $this->kernel->fetch('slug');
    }

    public function add(TagInterface $tag): void
    {
        $this->kernel->insert($tag);
    }

    public function collect(TagInterface ...$tags): void
    {
        $this->kernel->collect($tags);
    }

    public function merge(TagCollectionInterface $tags): TagCollectionInterface
    {
        return $this->kernel->merge($tags->toArray());
    }

    public function containsWithId(int $id): bool
    {
        return $this->kernel->hasWhere('id', '=', $id);
    }

    public function containsWithSlug(string $slug): bool
    {
        return $this->kernel->contains($slug);
    }

    public function removeWithId(int $id): TagCollectionInterface
    {
        return $this->kernel->where('id', '!=', $id);
    }

    public function removeWithSlug(string $slug): TagCollectionInterface
    {
        return $this->kernel->where('slug', '!=', $slug);
    }

    public function matches(TagCollectionInterface $tags): bool
    {
        return $this->kernel->matches($tags->toArray());
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
