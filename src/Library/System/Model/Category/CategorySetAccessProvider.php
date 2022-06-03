<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\SetAccessProvider;

class CategorySetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(CategoryInterface $tag, AutoInvokerInterface $invoker)
    {
        parent::__construct($tag, $this->resolvedSetters($tag, $invoker));
    }

    protected function resolvedSetters(CategoryInterface $tag, AutoInvokerInterface $invoker)
    {
        return [];
    }
}
