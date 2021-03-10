<?php

namespace WebTheory\Leonidas\Library\Admin\Fields\Selections;

use WP_Post;
use WebTheory\Leonidas\Library\Core\Util\PostCollection;
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
