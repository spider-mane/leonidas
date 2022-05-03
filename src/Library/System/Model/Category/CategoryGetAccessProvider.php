<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class CategoryGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(CategoryInterface $tag)
    {
        parent::__construct($tag, $this->resolvedGetters($tag));
    }

    protected function resolvedGetters(CategoryInterface $tag)
    {
        return [];
    }
}
