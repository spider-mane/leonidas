<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class PageCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$pages): PageCollection
    {
        return new PageCollection(...$pages);
    }
}
