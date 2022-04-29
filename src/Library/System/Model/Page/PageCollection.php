<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractSystemModelCollection;

class PageCollection extends AbstractSystemModelCollection implements PageCollectionInterface
{
    public function __construct(PageInterface ...$pages)
    {
        parent::__construct($pages);
    }

    public function getById(int $id): PageInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }
}
