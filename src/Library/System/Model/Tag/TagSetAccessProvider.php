<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Library\System\Model\SetAccessProvider;

class TagSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(TagInterface $tag)
    {
        parent::__construct($tag, $this->resolvedSetters($tag));
    }

    protected function resolvedSetters(TagInterface $tag)
    {
        return [];
    }
}
