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

    public function __construct(TagInterface ...$tags)
    {
        $this->initKernel($tags);
    }

    public function getById(int $id): TagInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
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
