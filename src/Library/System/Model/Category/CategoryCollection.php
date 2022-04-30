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

    public function __construct(CategoryInterface ...$categories)
    {
        $this->initKernel($categories);
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
