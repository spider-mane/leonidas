<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WebTheory\Leonidas\Util\PostCollection;
use WebTheory\Saveyour\Contracts\SuperSelectionProviderInterface;

abstract class AbstractPostCollectionSelection extends AbstractPostSuperSelection implements SuperSelectionProviderInterface
{
    /**
     * @var PostCollection
     */
    protected $collection;

    /**
     *
     */
    public function __construct(PostCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return WP_Post[]
     */
    public function provideItemsAsRawData(): array
    {
        return $this->collection->getPosts();
    }
}
