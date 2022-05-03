<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\SetAccessProvider;

class CategorySetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(CategoryInterface $tag)
    {
        parent::__construct($tag, $this->resolvedSetters($tag));
    }

    protected function resolvedSetters(CategoryInterface $tag)
    {
        return [];
    }
}
