<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Post;
use WP_Query;
use WebTheory\Saveyour\Contracts\SelectionProviderInterface;

abstract class AbstractPostQuerySelection extends AbstractPostSelectionProvider implements SelectionProviderInterface
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
        $this->query = $query;
    }

    /**
     * @return WP_Post[]
     */
    public function provideSelectionsData(): array
    {
        return $this->query->get_posts();
    }
}
