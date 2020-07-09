<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WP_Query;
use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;

class PostQueryChecklistItems extends AbstractPostChecklistItems implements ChecklistItemsInterface
{
    /**
     * @var WP_Query
     */
    protected $query;

    /**
     *
     */
    public function __construct(WP_Query $query)
    {
        $this->query = clone $query;
    }

    /**
     * @return WP_Post[]
     */
    protected function provideItemsAsRawData(): array
    {
        return $this->query->get_posts();
    }
}
