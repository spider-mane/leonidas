<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WebTheory\Leonidas\Util\PostCollection;
use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;

class PostCollectionChecklistItems extends AbstractPostChecklistItems implements ChecklistItemsInterface
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
        $this->collection = clone $collection;
    }

    /**
     * @return WP_Post[]
     */
    protected function provideItemsAsRawData(): array
    {
        return $this->collection->getPosts();
    }
}
