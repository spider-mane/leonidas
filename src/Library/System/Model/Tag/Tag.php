<?php

namespace Leonidas\Library\System\Model\Tag;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use WP_Term;

class Tag implements TagInterface
{
    protected WP_Term $tag;

    public function __construct(WP_Term $tag)
    {
        if ($tag->taxonomy === 'post_tag') {
            $this->tag = $tag;
        }

        throw new InvalidArgumentException('Term provided for "$tag" must be of taxonomy "post_tag"');
    }
}
