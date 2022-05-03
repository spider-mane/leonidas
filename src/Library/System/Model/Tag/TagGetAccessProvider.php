<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class TagGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(TagInterface $tag)
    {
        parent::__construct($tag, $this->resolvedGetters($tag));
    }

    protected function resolvedGetters(TagInterface $tag)
    {
        return [];
    }
}
