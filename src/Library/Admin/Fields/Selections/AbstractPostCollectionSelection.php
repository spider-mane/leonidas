<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\System\Schema\Post\PostCollection;
use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;
use WP_Post;

abstract class AbstractPostCollectionSelection extends AbstractPostSelectionProvider implements SelectionProviderInterface
{
    /**
     * @var PostCollection
     */
    protected $collection;

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
