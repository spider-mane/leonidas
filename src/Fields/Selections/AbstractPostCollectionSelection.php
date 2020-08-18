<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WebTheory\Leonidas\Util\PostCollection;
use WebTheory\Saveyour\Contracts\SelectionProviderInterface;

abstract class AbstractPostCollectionSelection extends AbstractPostSelectionProvider implements SelectionProviderInterface
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
    public function provideSelectionsData(): array
    {
        return $this->collection->getPosts();
    }
}
