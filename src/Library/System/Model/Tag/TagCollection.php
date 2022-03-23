<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use WP_Term;

class TagCollection implements TagCollectionInterface
{
    protected array $tags;

    public function __construct(TagInterface ...$tags)
    {
        $this->tags = $tags;
    }

    public function all(): array
    {
        return $this->tags;
    }

    public static function adapt(array $tags): TagCollection
    {
        return new static(...array_map(
            fn (WP_Term $tag) => new Tag($tag),
            $tags
        ));
    }
}
