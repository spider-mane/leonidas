<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;
use WP_Post;
use WP_Query;

abstract class AbstractPostQuerySelection extends AbstractPostSelectionProvider implements SelectionProviderInterface
{
    /**
     * @var WP_Query
     */
    protected $query;

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
