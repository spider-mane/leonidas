<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Leonidas\Library\System\Model\Page\Abstracts\AbstractPageCollection;

class PageCollection extends AbstractPageCollection implements PageCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'name';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(PageInterface ...$pages)
    {
        $this->initKernel($pages);
    }

    public function getByName(string $name): PageInterface
    {
        return $this->kernel->fetch($name);
    }

    public function hasWithName(string $name): bool
    {
        return $this->kernel->contains($name);
    }
}
